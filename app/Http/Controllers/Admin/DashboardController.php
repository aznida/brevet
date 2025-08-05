<?php

namespace App\Http\Controllers\Admin;

use App\Models\Exam;
use App\Models\Participant;
use App\Models\Area;
use App\Models\ExamSession; 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //count participants
        $participants = Participant::count();

        //count exams
        $exams = Exam::count();

        //count exam sessions
        $exam_sessions = ExamSession::count();

        //count areas
        $areas = Area::count();

        // Get area level statistics
        $areaLevelStats = Area::select('id', 'title')
            ->with(['participants' => function($query) {
                $query->select('id', 'name', 'area_id', 'witel','role')
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
                    } // Added missing closing bracket here
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
        
        // Get participant distribution data
        $participantDistribution = $this->getParticipantDistribution();
    
        return inertia('Admin/Dashboard/Index', [
            'participants'  => $participants,
            'exams'         => $exams,
            'exam_sessions' => $exam_sessions,
            'areas'         => $areas,
            'areaLevelStats' => $areaLevelStats,
            'assessmentData' => $assessmentData,
            'participantDistribution' => $participantDistribution
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
    
    /**
     * Get participant distribution by age groups and work experience groups per TREG
     */
    private function getParticipantDistribution()
    {
        // Get all areas (TREG)
        $areas = Area::orderBy('title')->get();
        
        $result = [
            'treg_names' => [], // Will hold TREG names
            'age_groups' => [
                '0-20' => [],
                '21-30' => [],
                '31-40' => [],
                '41-50' => [],
                '>50'   => []   
            ],
            'experience_groups' => [
                '<1' => [],
                '1-5' => [],
                '6-10' => [],
                '>10' => []
            ],
            // Data structure for age-skill distribution
            'age_skill_distribution' => [
                '0-20' => [],
                '21-30' => [],
                '31-40' => [],
                '41-50' => [],
                '>50' => [],
                'undefined' => []
            ],
            // New data structure for age-skill participants
            'age_skill_participants' => [
                '0-20' => [],
                '21-30' => [],
                '31-40' => [],
                '41-50' => [],
                '>50' => [],
                'undefined' => []
            ]
        ];
        
        foreach ($areas as $area) {
            // Add area title to categories
            $result['treg_names'][] = $area->title;
            
            // Get participants for this area
            $participants = Participant::where('area_id', $area->id)->get();
            
            // Count participants by age groups
            $ageGroups = [
                '0-20' => 0,
                '21-30' => 0,
                '31-40' => 0,
                '41-50' => 0,
                '>50' => 0,
            ];
            
            // Count participants by work experience groups
            $experienceGroups = [
                '<1' => 0,
                '1-5' => 0,
                '6-10' => 0,
                '>10' => 0
            ];
            
            // Count participants age range by skill level
            $ageSkillGroups = [
                '0-20' => [
                    'starter' => 0,
                    'basic' => 0,
                    'intermediate' => 0,
                    'advanced' => 0,
                    'expert' => 0
                ],
                '21-30' => [
                    'starter' => 0,
                    'basic' => 0,
                    'intermediate' => 0,
                    'advanced' => 0,
                    'expert' => 0
                ],
                '31-40' => [
                    'starter' => 0,
                    'basic' => 0,
                    'intermediate' => 0,
                    'advanced' => 0,
                    'expert' => 0
                ],
                '41-50' => [
                    'starter' => 0,
                    'basic' => 0,
                    'intermediate' => 0,
                    'advanced' => 0,
                    'expert' => 0
                ],
                '>50' => [
                    'starter' => 0,
                    'basic' => 0,
                    'intermediate' => 0,
                    'advanced' => 0,
                    'expert' => 0
                ],
                'undefined' => [
                    'starter' => 0,
                    'basic' => 0,
                    'intermediate' => 0,
                    'advanced' => 0,
                    'expert' => 0
                ],
            ];
            
            // Store participants by age group and skill level
            $ageSkillParticipants = [
                '0-20' => [
                    'starter' => [],
                    'basic' => [],
                    'intermediate' => [],
                    'advanced' => [],
                    'expert' => []
                ],
                '21-30' => [
                    'starter' => [],
                    'basic' => [],
                    'intermediate' => [],
                    'advanced' => [],
                    'expert' => []
                ],
                '31-40' => [
                    'starter' => [],
                    'basic' => [],
                    'intermediate' => [],
                    'advanced' => [],
                    'expert' => []
                ],
                '41-50' => [
                    'starter' => [],
                    'basic' => [],
                    'intermediate' => [],
                    'advanced' => [],
                    'expert' => []
                ],
                '>50' => [
                    'starter' => [],
                    'basic' => [],
                    'intermediate' => [],
                    'advanced' => [],
                    'expert' => []
                ],
                'undefined' => [
                    'starter' => [],
                    'basic' => [],
                    'intermediate' => [],
                    'advanced' => [],
                    'expert' => []
                ],
            ];
            
            foreach ($participants as $participant) {
                // Calculate age
                $age = $participant->getUsiaAttribute();
                
                // Determine age group
                $ageGroup = null;
                if ($age === null) {
                    $ageGroup = 'undefined';
                    if (!isset($ageGroups['undefined'])) {
                        $ageGroups['undefined'] = 0;
                    }
                    $ageGroups['undefined']++;
                } elseif ($age >= 0 && $age <= 20) {
                    $ageGroup = '0-20';
                    $ageGroups['0-20']++;
                } elseif ($age >= 21 && $age <= 30) {
                    $ageGroup = '21-30';
                    $ageGroups['21-30']++;
                } elseif ($age >= 31 && $age <= 40) {
                    $ageGroup = '31-40';
                    $ageGroups['31-40']++;
                } elseif ($age >= 41 && $age <= 50) {
                    $ageGroup = '41-50';
                    $ageGroups['41-50']++;
                } elseif ($age > 50) {
                    $ageGroup = '>50';
                    $ageGroups['>50']++;
                }
                
                // If we have a valid age group, calculate skill level
                if ($ageGroup) {
                    // Get participant's average grade to determine skill level
                    $grades = $participant->grades;
                    if ($grades->isNotEmpty()) {
                        // Define all weights
                        $weights = [
                            'multiple_choice' => 0.35,
                            'ujian_attitude' => 0.15,
                            'ujian_pratik' => 0.50
                        ];
                        
                        // Group grades by exam_type and calculate average for each type
                        $examTypeAverages = [];
                        $gradesByType = $grades->groupBy('exam_type');
                        
                        // Calculate averages for available exam types
                        foreach ($gradesByType as $examType => $typeGrades) {
                            if ($examType === null) continue;
                            
                            $validGrades = $typeGrades->filter(function($grade) {
                                return $grade->grade !== null;
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
                            
                            // Determine skill level based on average grade
                            $skillLevel = '';
                            if ($averageGrade >= 0 && $averageGrade <= 40) {
                                $skillLevel = 'starter';
                                $ageSkillGroups[$ageGroup]['starter']++;
                                
                                // Add participant to the appropriate age-skill group
                                $ageSkillParticipants[$ageGroup]['starter'][] = [
                                    'name' => $participant->name,
                                    'witel' => $participant->witel,
                                    'role' => $participant->role,
                                    'usia' => $participant->getUsiaAttribute(),
                                    'grade' => $averageGrade
                                ];
                            } elseif ($averageGrade <= 60) {
                                $skillLevel = 'basic';
                                $ageSkillGroups[$ageGroup]['basic']++;
                                
                                // Add participant to the appropriate age-skill group
                                $ageSkillParticipants[$ageGroup]['basic'][] = [
                                    'name' => $participant->name,
                                    'witel' => $participant->witel,
                                    'role' => $participant->role,
                                    'usia' => $participant->getUsiaAttribute(),
                                    'grade' => $averageGrade
                                ];
                            } elseif ($averageGrade <= 75) {
                                $skillLevel = 'intermediate';
                                $ageSkillGroups[$ageGroup]['intermediate']++;
                                
                                // Add participant to the appropriate age-skill group
                                $ageSkillParticipants[$ageGroup]['intermediate'][] = [
                                    'name' => $participant->name,
                                    'witel' => $participant->witel,
                                    'role' => $participant->role,
                                    'usia' => $participant->getUsiaAttribute(),
                                    'grade' => $averageGrade
                                ];
                            } elseif ($averageGrade <= 90) {
                                $skillLevel = 'advanced';
                                $ageSkillGroups[$ageGroup]['advanced']++;
                                
                                // Add participant to the appropriate age-skill group
                                $ageSkillParticipants[$ageGroup]['advanced'][] = [
                                    'name' => $participant->name,
                                    'witel' => $participant->witel,
                                    'role' => $participant->role,
                                    'usia' => $participant->getUsiaAttribute(),
                                    'grade' => $averageGrade
                                ];
                            } else {
                                $skillLevel = 'expert';
                                $ageSkillGroups[$ageGroup]['expert']++;
                                
                                // Add participant to the appropriate age-skill group
                                $ageSkillParticipants[$ageGroup]['expert'][] = [
                                    'name' => $participant->name,
                                    'witel' => $participant->witel,
                                    'role' => $participant->role,
                                    'usia' => $participant->getUsiaAttribute(),
                                    'grade' => $averageGrade
                                ];
                            }
                        }
                    }
                }
            }
            
            $result['age_groups']['0-20'][] = $ageGroups['0-20'];
            $result['age_groups']['21-30'][] = $ageGroups['21-30'];
            $result['age_groups']['31-40'][] = $ageGroups['31-40'];
            $result['age_groups']['41-50'][] = $ageGroups['41-50'];
            $result['age_groups']['>50'][] = $ageGroups['>50'];
            
            // Add undefined age-skill distribution - properly handle this case
            if (isset($ageGroups['undefined'])) {
                if (!isset($result['age_groups']['undefined'])) {
                    $result['age_groups']['undefined'] = [];
                }
                $result['age_groups']['undefined'][] = $ageGroups['undefined'];
            }
            
            // Add age-skill distribution counts for each age group
            foreach ($ageSkillGroups as $ageGroup => $skillCounts) {
                foreach ($skillCounts as $skill => $count) {
                    if (!isset($result['age_skill_distribution'][$ageGroup])) {
                        $result['age_skill_distribution'][$ageGroup] = [];
                    }
                    if (!isset($result['age_skill_distribution'][$ageGroup][$skill])) {
                        $result['age_skill_distribution'][$ageGroup][$skill] = [];
                    }
                    $result['age_skill_distribution'][$ageGroup][$skill][] = $count;
                }
            }
            
            // Add age-skill participants for each age group
            foreach ($ageSkillParticipants as $ageGroup => $skillParticipants) {
                foreach ($skillParticipants as $skill => $participants) {
                    if (!isset($result['age_skill_participants'][$ageGroup])) {
                        $result['age_skill_participants'][$ageGroup] = [];
                    }
                    if (!isset($result['age_skill_participants'][$ageGroup][$skill])) {
                        $result['age_skill_participants'][$ageGroup][$skill] = [];
                    }
                    $result['age_skill_participants'][$ageGroup][$skill][] = $participants;
                }
            }
        }
        
        return $result;
    }
}

// Around line 43, you likely have something like:
$participants = Participant::with('grades')->get();


