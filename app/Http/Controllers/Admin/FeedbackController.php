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
        
        return Inertia::render('Admin/Feedback/Index', [
            'feedback' => $feedback,
            'filters' => $request->only('search'),
            'stats' => [
                'averageSatisfaction' => round($averageSatisfaction, 1),
                'averageRelevance' => round($averageRelevance, 1)
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

// Add this after line 73 to debug what areas exist
$allAreas = \DB::table('areas')->orderBy('title')->get();
\Log::info('All areas in database:', $allAreas->toArray());