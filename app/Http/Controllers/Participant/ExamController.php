<?php

namespace App\Http\Controllers\Participant;

use App\Models\Grade;
use App\Models\ExamGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Answer;
use App\Models\Question;

class ExamController extends Controller
{
        /**
     * confirmation
     *
     * @param  mixed $id
     * @return void
     */
    public function confirmation($id)
    {
        //get exam group
        $exam_group = ExamGroup::with('exam.category', 'exam_session', 'participant.area')
                    ->where('participant_id', auth()->guard('participant')->user()->id)
                    ->where('id', $id)
                    ->first();

        //get grade / nilai
        $grade = Grade::where('exam_id', $exam_group->exam->id)
                    ->where('exam_session_id', $exam_group->exam_session->id)
                    ->where('participant_id', auth()->guard('participant')->user()->id)
                    ->first();
        
        //return with inertia
        return inertia('Participant/Exams/Confirmation', [
            'exam_group' => $exam_group,
            'grade' => $grade,
        ]);
    }

    /**
     * startExam
     *
     * @param  mixed $id
     * @return void
     */
    public function startExam($id)
    {
        //get exam group
        $exam_group = ExamGroup::with('exam.category', 'exam_session', 'participant.area')
                    ->where('participant_id', auth()->guard('participant')->user()->id)
                    ->where('id', $id)
                    ->first();

        //get grade / nilai
        $grade = Grade::where('exam_id', $exam_group->exam->id)
                    ->where('exam_session_id', $exam_group->exam_session->id)
                    ->where('participant_id', auth()->guard('participant')->user()->id)
                    ->first();

        //update start time di table grades
        $grade->start_time = Carbon::now();
        $grade->update();

        //cek apakah questions / soal ujian di random
        if($exam_group->exam->random_question == 'Y') {

            //get questions / soal ujian
            $questions = Question::where('exam_id', $exam_group->exam->id)->inRandomOrder()->get();

        } else {

            //get questions / soal ujian
            $questions = Question::where('exam_id', $exam_group->exam->id)->get();

        }

        //define pilihan jawaban default
        $question_order = 1;

        foreach ($questions as $question) {

            //buat array jawaban / answer
            $options = [1,2];
            if(!empty($question->option_3)) $options[] = 3;
            if(!empty($question->option_4)) $options[] = 4;
            if(!empty($question->option_5)) $options[] = 5;

            //acak jawaban / answer
            if($exam_group->exam->random_answer == 'Y') {
                shuffle($options);
            }

            //cek apakah sudah ada data jawaban
            $answer = Answer::where('participant_id', auth()->guard('participant')->user()->id)
                    ->where('exam_id', $exam_group->exam->id)
                    ->where('exam_session_id', $exam_group->exam_session->id)
                    ->where('question_id', $question->id)
                    ->first();

            //jika sudah ada jawaban / answer
            if($answer) {

                //update urutan question / soal
                $answer->question_order = $question_order;
                $answer->update();

            } else {

                //buat jawaban default baru
                Answer::create([
                    'exam_id'           => $exam_group->exam->id,
                    'exam_session_id'   => $exam_group->exam_session->id,
                    'question_id'       => $question->id,
                    'participant_id'        => auth()->guard('participant')->user()->id,
                    'question_order'    => $question_order,
                    'answer_order'      => implode(",", $options),
                    'answer'            => 0,
                    'is_correct'        => 'N'
                ]);

            }
            $question_order++;

        }

        //redirect ke ujian halaman 1
        return redirect()->route('participant.exams.show', [
            'id'    => $exam_group->id, 
            'page'  => 1
        ]);   
    }
    
    /**
     * show
     *
     * @param  mixed $id
     * @param  mixed $page
     * @return void
     */
    public function show($id, $page)
    {
        //get exam group
        $exam_group = ExamGroup::with('exam.category', 'exam_session', 'participant.area')
                    ->where('participant_id', auth()->guard('participant')->user()->id)
                    ->where('id', $id)
                    ->first();

        if(!$exam_group) {
            return redirect()->route('participant.dashboard');
        }

        // Get total questions to show
        $totalQuestions = $exam_group->exam->showqty;
        
        // Calculate proportions for each level
        $basicCount = ceil($totalQuestions * 0.30);      // 30% Basic
        $intermediateCount = ceil($totalQuestions * 0.30); // 30% Intermediate
        $advancedCount = ceil($totalQuestions * 0.30);    // 30% Advanced
        $expertCount = $totalQuestions - ($basicCount + $intermediateCount + $advancedCount); // remaining for Expert

        // Get questions from answers table
        $questions = Answer::with('question')
            ->where('participant_id', auth()->guard('participant')->user()->id)
            ->where('exam_id', $exam_group->exam->id)
            ->get()
            ->groupBy(function($item) {
                return $item->question->level;
            });

        // Initialize collection
        $all_questions = collect();

        // Add Basic questions
        if(isset($questions['Basic'])) {
            $all_questions = $all_questions->concat($questions['Basic']->take($basicCount));
        }
        if(isset($questions['Intermediate'])) {
            $all_questions = $all_questions->concat($questions['Intermediate']->take($intermediateCount));
        }
        if(isset($questions['Advanced'])) {
            // If Expert questions don't exist, add extra Advanced questions to make up for it
            $advancedToTake = isset($questions['Expert']) ? $advancedCount : ($advancedCount + $expertCount);
            $all_questions = $all_questions->concat($questions['Advanced']->take($advancedToTake));
        }
        if(isset($questions['Expert'])) {
            $all_questions = $all_questions->concat($questions['Expert']->take($expertCount));
        }

        // Ensure exact number of questions and proper ordering
        $all_questions = $all_questions->take($totalQuestions)
                                     ->sortBy('question_order')
                                     ->values();

        // Get question active based on available questions
        $question_active = $all_questions->where('question_order', $page)->first();
        
        //count all question answered
        $question_answered = Answer::with('question')
                        ->where('participant_id', auth()->guard('participant')->user()->id)
                        ->where('exam_id', $exam_group->exam->id)
                        ->where('answer', '!=', 0)
                        ->count();


        //get question active
        $question_active = Answer::with('question.exam')
                        ->where('participant_id', auth()->guard('participant')->user()->id)
                        ->where('exam_id', $exam_group->exam->id)
                        ->where('question_order', $page)
                        ->first();
        
        //explode atau pecah jawaban
        if ($question_active) {
            $answer_order = explode(",", $question_active->answer_order);
        } else  {
            $answer_order = [];
        }

        //get duration
        $duration = Grade::where('exam_id', $exam_group->exam->id)
                    ->where('exam_session_id', $exam_group->exam_session->id)
                    ->where('participant_id', auth()->guard('participant')->user()->id)
                    ->first();

        //return with inertia
        return inertia('Participant/Exams/Show', [
            'id'                => (int) $id,
            'page'              => (int) $page,
            'exam_group'        => $exam_group,
            'all_questions'     => $all_questions,
            'question_answered' => $question_answered,
            'question_active'   => $question_active,
            'answer_order'      => $answer_order,
            'duration'          => $duration,
        ]); 
    }
     /**
     * updateDuration
     *
     * @param  mixed $request
     * @param  mixed $grade_id
     * @return void
     */
    public function updateDuration(Request $request, $grade_id)
    {
        $grade = Grade::find($grade_id);
        $grade->duration = $request->duration;
        $grade->update();

        return response()->json([
            'success'  => true,
            'message' => 'Duration updated successfully.'
        ]);
    }

            /**
     * answerQuestion
     *
     * @param  mixed $request
     * @return void
     */
    public function answerQuestion(Request $request)
    {
        //update duration
        $grade = Grade::where('exam_id', $request->exam_id)
                ->where('exam_session_id', $request->exam_session_id)
                ->where('participant_id', auth()->guard('participant')->user()->id)
                ->first();

        $grade->duration = $request->duration;
        $grade->update();

        //get question
        $question = Question::find($request->question_id);
        
        //cek apakah jawaban sudah benar
        if($question->answer == $request->answer) {

            //jawaban benar
            $result = 'Y';
        } else {

            //jawaban salah
            $result = 'N';
        }

        //get answer
        $answer   = Answer::where('exam_id', $request->exam_id)
                    ->where('exam_session_id', $request->exam_session_id)
                    ->where('participant_id', auth()->guard('participant')->user()->id)
                    ->where('question_id', $request->question_id)
                    ->first();

        //update jawaban
        if($answer) {
            $answer->answer     = $request->answer;
            $answer->is_correct = $result;
            $answer->update();
        }

        return redirect()->back();
    }
    
    /**
     * endExam
     *
     * @param  mixed $request
     * @return void
     */
    public function endExam(Request $request)
    {
        //get exam group to get showqty
        $exam_group = ExamGroup::with('exam')->find($request->exam_group_id);
        
        //count jawaban benar
        $count_correct_answer = Answer::where('exam_id', $request->exam_id)
                            ->where('exam_session_id', $request->exam_session_id)
                            ->where('participant_id', auth()->guard('participant')->user()->id)
                            ->where('is_correct', 'Y')
                            ->count();

        //use showqty instead of total questions
        $total_questions = $exam_group->exam->showqty;

        //hitung nilai
        $grade_exam = round($count_correct_answer/$total_questions*100, 2);

        //update nilai di table grades
        $grade = Grade::where('exam_id', $request->exam_id)
                ->where('exam_session_id', $request->exam_session_id)
                ->where('participant_id', auth()->guard('participant')->user()->id)
                ->first();
        
        $grade->end_time        = Carbon::now();
        $grade->total_correct   = $count_correct_answer;
        $grade->grade          = $grade_exam;
        $grade->exam_type      = $exam_group->exam->exam_type;
        $grade->update();

        //redirect hasil
        return redirect()->route('participant.exams.resultExam', $request->exam_group_id);
    }

    /**
     * resultExam
     *
     * @param  mixed $id
     * @return void
     */
    public function resultExam($exam_group_id)
    {
        //get exam group
        $exam_group = ExamGroup::with('exam.category', 'exam_session', 'participant.area')
                ->where('participant_id', auth()->guard('participant')->user()->id)
                ->where('id', $exam_group_id)
                ->first();

        //get grade / nilai
        $grade = Grade::where('exam_id', $exam_group->exam->id)
                ->where('exam_session_id', $exam_group->exam_session->id)
                ->where('participant_id', auth()->guard('participant')->user()->id)
                ->first();

        //return with inertia
        return inertia('Participant/Exams/Result', [
            'exam_group' => $exam_group,
            'grade'      => $grade,
        ]);
    }

}
