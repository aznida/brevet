<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use App\Models\ExamGroup;
use App\Models\Grade;
use App\Models\ExamDuration;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Participant;

class ExamPraktikController extends Controller
{
    public function startExam($id)
    {
        $exam_group = ExamGroup::with('exam.category', 'exam_session', 'participant.area')
            ->where('participant_id', auth()->guard('participant')->user()->id)
            ->where('id', $id)
            ->first();

        // Only create grade if it doesn't exist and hasn't been submitted yet
        $existingGrade = Grade::where([
            'exam_id' => $exam_group->exam_id,
            'exam_session_id' => $exam_group->exam_session_id,
            'participant_id' => auth()->guard('participant')->user()->id,
        ])->whereNull('end_time')->first();

        if (!$existingGrade) {
            Grade::create([
                'exam_id' => $exam_group->exam_id,
                'exam_session_id' => $exam_group->exam_session_id,
                'participant_id' => auth()->guard('participant')->user()->id,
                'start_time' => Carbon::now(),
                'duration' => $exam_group->exam->duration * 60 * 1000, // Convert minutes to milliseconds
            ]);
        }

        return redirect()->route('participant.exam.praktik', [
            'exam_group' => $exam_group->id
        ]);
    }

    public function store(Request $request, ExamGroup $exam_group)
    {
        $request->validate([
            'grades' => 'required|array',
            'grades.*' => 'required|numeric|min:0|max:100',
            'is_draft' => 'required|boolean',
            'grade_id_to_delete' => 'nullable|numeric'
        ]);

        // Delete existing grade for logged-in user if exists
        if (!$request->is_draft && $request->grade_id_to_delete) {
            Grade::where('id', $request->grade_id_to_delete)
                 ->where('participant_id', auth()->guard('participant')->user()->id)
                 ->delete();

            // Add total_correct when creating completed grade
            // Grade::create([
            //     'exam_id' => $exam_group->exam_id,
            //     'exam_session_id' => $exam_group->exam_session_id,
            //     'participant_id' => auth()->guard('participant')->user()->id,
            //     'start_time' => Carbon::now(),
            //     'end_time' => Carbon::now(),
            //     'is_completed' => true,
            //     'total_correct' => null,
            //     'grade' => null,
            //     'exam_type' => null
            // ]);
        }

        foreach ($request->grades as $participantId => $grade) {
            $isLoggedInUser = $participantId == auth()->guard('participant')->user()->id;
            
            Grade::updateOrCreate(
                [
                    'exam_id' => $exam_group->exam_id,
                    'exam_session_id' => $exam_group->exam_session_id,
                    'participant_id' => $participantId,
                ],
                [
                    'grade' => $grade,
                    'total_correct' => $grade,
                    'exam_type' => $isLoggedInUser ? null : $request->exam_type,
                    'start_time' => Carbon::now(),
                    'end_time' => $request->is_draft ? null : Carbon::now(),
                    'duration' => $request->duration ?? 0,
                ]
            );
        }
        
        // Delete existing grades if any
        if (!$request->is_draft && !empty($request->grade_ids_to_delete)) {
            Grade::whereIn('id', $request->grade_ids_to_delete)->delete();
        }

        $message = $request->is_draft ? 'Draft nilai berhasil disimpan!' : 'Nilai praktik berhasil disubmit!';

        return redirect()->route('participant.dashboard')
            ->with('success', $message);
    }

    public function endExam(Request $request)
    {
        $grade = Grade::where('exam_id', $request->exam_id)
            ->where('exam_session_id', $request->exam_session_id)
            ->where('participant_id', auth()->guard('participant')->user()->id)
            ->first();
        
        $grade->end_time = Carbon::now();
        $grade->update();

        return redirect()->route('participant.dashboard')
            ->with('success', 'Ujian praktik berhasil diselesaikan!');
    }

    public function show(ExamGroup $exam_group)
    {
        $grades = Grade::where('exam_id', $exam_group->exam_id)
            ->where('exam_session_id', $exam_group->exam_session_id)
            ->get();

        $participants = Participant::with('area')
            ->where('witel', auth()->guard('participant')->user()->witel)
            ->get();

        // Calculate remaining duration from current time to end_time
        $endTime = Carbon::parse($exam_group->exam_session->end_time);
        $remainingDuration = Carbon::now()->diffInMilliseconds($endTime);

        return inertia('Participant/Exams/PraktikExam', [
            'exam_group' => $exam_group->load(['participant.area', 'exam', 'exam_session']),
            'grades' => $grades,
            'participants' => $participants,
            'duration' => [
                'id' => $exam_group->id,
                'duration' => $remainingDuration
            ]
        ]);
    }
}