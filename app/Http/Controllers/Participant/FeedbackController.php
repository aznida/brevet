<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use App\Models\ParticipantFeedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Store participant feedback
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'exam_session_id' => 'required|exists:exam_sessions,id',
            'participant_id' => 'required|exists:participants,id',
            'satisfaction_rating' => 'required|integer|min:1|max:5',
            'relevance_rating' => 'required|integer|min:1|max:5',
            'comments' => 'required|string'
        ]);
        
        // Create feedback
        ParticipantFeedback::create($validated);
        
        return redirect()->back()->with('success', 'Feedback berhasil disimpan');
    }
}