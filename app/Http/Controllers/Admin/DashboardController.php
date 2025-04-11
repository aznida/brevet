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
                $query->select('id', 'name', 'area_id', 'witel')  // Add witel to the select
                    ->with(['grades' => function($q) {
                        $q->select('id', 'participant_id', 'grade', 'exam_id')
                            ->whereNotNull('end_time');
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
                    // Get the highest grade for the participant
                    $highestGrade = $participant->grades->max('grade');
                    
                    // Skip if no grades
                    if ($highestGrade === null) continue;
                    
                    $participantData = [
                        'name' => $participant->name,
                        'grade' => $highestGrade,
                        'witel' => $participant->witel  // Add witel field
                    ];
                    
                    // Categorize based on highest grade
                    if ($highestGrade >= 0 && $highestGrade <= 30) {
                        $participantsByLevel['starter'][] = $participantData;
                    } elseif ($highestGrade <= 60) {
                        $participantsByLevel['basic'][] = $participantData;
                    } elseif ($highestGrade <= 70) {
                        $participantsByLevel['intermediate'][] = $participantData;
                    } elseif ($highestGrade <= 90) {
                        $participantsByLevel['advanced'][] = $participantData;
                    } else {
                        $participantsByLevel['expert'][] = $participantData;
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

        return inertia('Admin/Dashboard/Index', [
            'participants'  => $participants,
            'exams'         => $exams,
            'exam_sessions' => $exam_sessions,
            'areas'         => $areas,
            'areaLevelStats' => $areaLevelStats
        ]);
    }
}