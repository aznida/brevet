<?php

namespace App\Http\Controllers\Admin;

use App\Models\Area;
use App\Models\Exam;
use App\Models\ExamSession;
use App\Models\Participant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MitraDashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // Get counts for dashboard stats
        $participantsCount = Participant::count();
        $examsCount = Exam::count();
        $examSessionsCount = ExamSession::count();
        $areasCount = Area::count();

        // Get area level statistics (Level Stream per Regional)
        $areaLevelStats = Area::select('id', 'title')
            ->with(['participants' => function($query) {
                $query->select('id', 'name', 'area_id', 'witel', 'role')
                    ->with(['grades' => function($q) {
                        $q->select('id', 'participant_id', 'grade', 'exam_id', 'exam_type')
                            ->whereNotNull('end_time')
                            ->whereNotNull('grade')
                            ->whereNotNull('exam_type');
                    }]);
            }])
            ->get()
            ->map(function($area) {
                $participantsByLevel = [
                    'starter' => [],
                    'basic' => [],
                    'intermediate' => [],
                    'advanced' => [],
                    'expert' => []
                ];

                foreach ($area->participants as $participant) {
                    if ($participant->grades->isEmpty()) continue;
                    
                    // Group grades by exam_type and calculate average for each type
                    $examTypeAverages = [];
                    $grades = $participant->grades->groupBy('exam_type');
                    
                    // Define all weights
                    $weights = [
                        'multiple_choice' => 0.35,
                        'ujian_attitude' => 0.15,
                        'ujian_pratik' => 0.50
                    ];

                    // Calculate averages for available exam types
                    foreach ($grades as $examType => $typeGrades) {
                        if ($examType === null) continue;
                        
                        $validGrades = $typeGrades->filter(function($grade) {
                            return $grade->grade !== null; // Ubah dari grade > 0 menjadi grade !== null
                        });
                        
                        if ($validGrades->isNotEmpty()) {
                            $examTypeAverages[$examType] = $validGrades->avg('grade');
                        }
                    }

                    // Calculate weighted sum
                    $weightedSum = 0;
                    $totalWeight = 0;

                    // Apply weights for all exam types, use 0 for missing ones
                    foreach ($weights as $examType => $weight) {
                        $grade = $examTypeAverages[$examType] ?? 0;
                        $weightedSum += $grade * $weight;
                        $totalWeight += $weight;
                    }

                    // Only process if there are any valid grades and weighted sum is not 0
                    if (!empty($examTypeAverages) && $weightedSum > 0) {
                        $averageGrade = round($weightedSum, 2);
                        
                        $participantData = [
                            'name' => $participant->name,
                            'role' => $participant->role,
                            'grade' => $averageGrade,
                            'witel' => $participant->witel
                        ];
                    
                        // Categorize based on average grade
                        if ($averageGrade >= 0 && $averageGrade <= 40) {
                            if (!collect($participantsByLevel['starter'])->contains('name', $participant->name)) {
                                $participantsByLevel['starter'][] = $participantData;
                            }
                        } elseif ($averageGrade <= 60) {
                            if (!collect($participantsByLevel['basic'])->contains('name', $participant->name)) {
                                $participantsByLevel['basic'][] = $participantData;
                            }
                        } elseif ($averageGrade <= 75) {
                            if (!collect($participantsByLevel['intermediate'])->contains('name', $participant->name)) {
                                $participantsByLevel['intermediate'][] = $participantData;
                            }
                        } elseif ($averageGrade <= 90) {
                            if (!collect($participantsByLevel['advanced'])->contains('name', $participant->name)) {
                                $participantsByLevel['advanced'][] = $participantData;
                            }
                        } else {
                            if (!collect($participantsByLevel['expert'])->contains('name', $participant->name)) {
                                $participantsByLevel['expert'][] = $participantData;
                            }
                        }
                    }
                }

                // Debug information
                \Log::info("Area {$area->title} participants:", [
                    'total_participants' => $area->participants->count(),
                    'participants_with_grades' => $area->participants->filter(function($p) {
                        return $p->grades->isNotEmpty();
                    })->count(),
                    'level_counts' => [
                        'starter' => count($participantsByLevel['starter']),
                        'basic' => count($participantsByLevel['basic']),
                        'intermediate' => count($participantsByLevel['intermediate']),
                        'advanced' => count($participantsByLevel['advanced']),
                        'expert' => count($participantsByLevel['expert']),
                    ]
                ]);

                return [
                    'title' => $area->title,
                    'starter' => count($participantsByLevel['starter']),
                    'basic' => count($participantsByLevel['basic']),
                    'intermediate' => count($participantsByLevel['intermediate']),
                    'advanced' => count($participantsByLevel['advanced']),
                    'expert' => count($participantsByLevel['expert']),
                    'starter_participants' => $participantsByLevel['starter'],
                    'basic_participants' => $participantsByLevel['basic'],
                    'intermediate_participants' => $participantsByLevel['intermediate'],
                    'advanced_participants' => $participantsByLevel['advanced'],
                    'expert_participants' => $participantsByLevel['expert'],
                ];
            });
        
        // Get assessment data by category
        $assessmentData = $this->getAssessmentDataByCategory();
    
        return inertia('Admin/Dashboard/Mitra', [
            'participants' => $participantsCount,
            'exams' => $examsCount,
            'exam_sessions' => $examSessionsCount,
            'areas' => $areasCount,
            'areaLevelStats' => $areaLevelStats,
            'assessmentData' => $assessmentData
        ]);
    }
    
    /**
     * Get assessment data grouped by category and level
     */
    private function getAssessmentDataByCategory()
    {
        // Define the specific 5 categories to show
        $categories = ['Mechanical', 'Electrical', 'Maintenance', 'Monitoring', 'Automation', 'Attitude', 'Praktik'];
        
        $assessmentData = [
            'categories' => $categories, // Add categories to the response
            'starter' => [],
            'basic' => [],
            'intermediate' => [],
            'advanced' => [],
            'expert' => []
        ];
    
        foreach ($categories as $category) {
            // Get grades for each category
            $grades = \App\Models\Grade::whereHas('exam.category', function($query) use ($category) {
                $query->where('title', $category);
            })
            ->whereHas('participant', function($query) {
                $query->where('role', '!=', 'supervisor');
            })
            ->whereNotNull('end_time')
            #->where('grade', '>', 0)
            ->whereNotNull('grade')
            ->whereNotNull('exam_type') // Filter tambahan di sini
            ->with(['participant', 'exam.category'])
            ->get();
            
            $categoryLevels = [
                'starter' => 0,
                'basic' => 0,
                'intermediate' => 0,
                'advanced' => 0,
                'expert' => 0
            ];
            
            // Group grades by participant to get their average for this category
            $participantGrades = $grades->groupBy('participant_id');
            
            foreach ($participantGrades as $participantId => $participantGradesList) {
                $averageGrade = $participantGradesList->avg('grade');
                
                // Categorize based on average grade
                if ($averageGrade >= 0 && $averageGrade <= 40) {
                    $categoryLevels['starter']++;
                } elseif ($averageGrade <= 60) {
                    $categoryLevels['basic']++;
                } elseif ($averageGrade <= 75) {
                    $categoryLevels['intermediate']++;
                } elseif ($averageGrade <= 90) {
                    $categoryLevels['advanced']++;
                } else {
                    $categoryLevels['expert']++;
                }
            }
            
            // Add to assessment data
            $assessmentData['starter'][] = $categoryLevels['starter'];
            $assessmentData['basic'][] = $categoryLevels['basic'];
            $assessmentData['intermediate'][] = $categoryLevels['intermediate'];
            $assessmentData['advanced'][] = $categoryLevels['advanced'];
            $assessmentData['expert'][] = $categoryLevels['expert'];
        }
        
        return $assessmentData;
    }  
}