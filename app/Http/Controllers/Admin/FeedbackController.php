<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExamSession;
use App\Models\ParticipantFeedback;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FeedbackController extends Controller
{
    /**
     * Display a listing of all feedback
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        // Debug: Check if the table exists and has data
        $tableExists = Schema::hasTable('participant_feedback');
        $rawCount = DB::table('participant_feedback')->count();
        $modelCount = ParticipantFeedback::count();
        
        // Debug: Get a sample record if any exists
        $sampleRecord = DB::table('participant_feedback')->first();
        
        // Get feedback with pagination and relationships
        $feedback = ParticipantFeedback::with(['participant.area', 'examSession'])
            ->when($request->search, function($query, $search) {
                $query->whereHas('participant', function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                })->orWhereHas('examSession', function($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // Calculate overall average ratings
        $averageSatisfaction = ParticipantFeedback::avg('satisfaction_rating');
        $averageRelevance = ParticipantFeedback::avg('relevance_rating');
        
        // Debug: Check total feedback count
        $totalFeedbackCount = ParticipantFeedback::count();
        
        // Debug: Check if there are any non-zero ratings
        $nonZeroSatisfaction = ParticipantFeedback::where('satisfaction_rating', '>', 0)->count();
        $nonZeroRelevance = ParticipantFeedback::where('relevance_rating', '>', 0)->count();

        // Get area-based statistics with corrected column name
        $areaStats = ParticipantFeedback::join('exam_sessions', 'participant_feedback.exam_session_id', '=', 'exam_sessions.id')
            ->join('exams', 'exam_sessions.exam_id', '=', 'exams.id')
            ->join('areas', 'exams.area_id', '=', 'areas.id')
            ->selectRaw('areas.title as area_name,
                        ROUND(AVG(participant_feedback.satisfaction_rating), 1) as avg_satisfaction,
                        ROUND(AVG(participant_feedback.relevance_rating), 1) as avg_relevance,
                        COUNT(participant_feedback.id) as feedback_count')
            ->groupBy('areas.id', 'areas.title')
            ->orderBy('areas.title')
            ->get()
            ->map(function ($stat) {
                return [
                    'area_name' => $stat->area_name,
                    'avg_satisfaction' => (float) ($stat->avg_satisfaction ?? 0),
                    'avg_relevance' => (float) ($stat->avg_relevance ?? 0),
                    'feedback_count' => (int) ($stat->feedback_count ?? 0)
                ];
            });

        return Inertia::render('Admin/Feedback/Index', [
            'feedback' => $feedback,
            'filters' => $request->only('search'),
            'stats' => [
                'averageSatisfaction' => round($averageSatisfaction, 1),
                'averageRelevance' => round($averageRelevance, 1),
                'areaStats' => $areaStats,
                // Remove debug info after fixing
                'debug' => [
                    'tableExists' => $tableExists,
                    'rawCount' => $rawCount,
                    'modelCount' => $modelCount,
                    'totalFeedbackCount' => $totalFeedbackCount,
                    'nonZeroSatisfaction' => $nonZeroSatisfaction,
                    'nonZeroRelevance' => $nonZeroRelevance,
                    'sampleRecord' => $sampleRecord,
                    'connectionName' => config('database.default'),
                    'databaseName' => config('database.connections.' . config('database.default') . '.database'),
                    'areaStatsCount' => $areaStats->count(),
                    'areaStatsData' => $areaStats->toArray()
                ]
            ]
        ]);
    }

    /**
     * Display feedback for a specific exam session
     *
     * @param ExamSession $exam_session
     * @return \Inertia\Response
     */
    public function examSessionFeedback(ExamSession $exam_session)
    {
        // Load the exam session with feedback and participants
        $exam_session->load(['feedback.participant']);

        // Calculate average ratings for this session
        $averageSatisfaction = $exam_session->feedback->avg('satisfaction_rating');
        $averageRelevance = $exam_session->feedback->avg('relevance_rating');

        return Inertia::render('Admin/Feedback/ExamSession', [
            'examSession' => $exam_session,
            'feedback' => $exam_session->feedback,
            'stats' => [
                'averageSatisfaction' => round($averageSatisfaction, 1),
                'averageRelevance' => round($averageRelevance, 1),
                'totalResponses' => $exam_session->feedback->count(),
            ]
        ]);
    }
}