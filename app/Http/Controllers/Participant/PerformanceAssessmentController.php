<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use App\Models\PerformanceAssessment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerformanceAssessmentController extends Controller
{
    public function index()
    {
        $assessments = Auth::guard('participant')
            ->user()
            ->assessorAssessments()
            ->with('assessment')
            ->get();

        return view('participant.performance_assessments.index', compact('assessments'));
    }

    public function show(PerformanceAssessment $assessment)
    {
        $questions = $assessment->questions;
        return view('participant.performance_assessments.show', compact('assessment', 'questions'));
    }

    public function submit(Request $request, PerformanceAssessment $assessment)
    {
        $participant = Auth::guard('participant')->user();
        
        // Verify participant is assigned as assessor for this assessment
        if (!$assessment->assessors()->where('id', $participant->id)->exists()) {
            abort(403);
        }

        $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|integer|min:1|max:5'
        ]);

        // Store answers
        foreach ($request->answers as $questionId => $rating) {
            $assessment->answers()->create([
                'assessor_id' => $participant->id,
                'question_id' => $questionId,
                'rating' => $rating
            ]);
        }

        // Update assessment status
        $participant->assessorAssessments()
            ->updateExistingPivot($assessment->id, ['status' => 'completed']);

        return redirect()->route('participant.performance_assessments.index');
    }
}