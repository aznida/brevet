<?php

namespace App\Http\Controllers\Participant;

use App\Models\Grade;
use App\Models\ExamGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Category;

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
        
        // Get questions from answers table
        $questions = Answer::with('question')
            ->where('participant_id', auth()->guard('participant')->user()->id)
            ->where('exam_id', $exam_group->exam->id)
            ->get()
            ->groupBy(function($item) {
                return $item->question->level;
            });

        // Hitung total soal yang tersedia
        $availableQuestions = $questions->flatten()->count();

        // Jika total soal yang tersedia sama dengan showqty, tampilkan semua
        if ($availableQuestions <= $totalQuestions) {
            $all_questions = $questions->flatten()
                                     ->sortBy('question_order')
                                     ->values();
        } else {
            // Calculate proportions for each level
            $basicCount = ceil($totalQuestions * 0.30);      // 30% Basic
            $intermediateCount = ceil($totalQuestions * 0.30); // 30% Intermediate
            $advancedCount = ceil($totalQuestions * 0.30);    // 30% Advanced
            $expertCount = $totalQuestions - ($basicCount + $intermediateCount + $advancedCount); // remaining for Expert

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
        }

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
        
        //get exam category
        $exam = $question->exam;
        $category_title = strtolower($exam->category->title);
        
        //cek apakah kategori mengandung kata attitude/sikap/akhlak
        if(str_contains($category_title, 'attitude') || 
           str_contains($category_title, 'sikap') || 
           str_contains($category_title, 'akhlak')) {
            
            //untuk ujian attitude, nilai jawaban adalah nilai yang dipilih
            $result = 'Y';
            $answer_value = $request->answer; // Simpan jawaban asli yang dipilih
            
        } else {
            //untuk ujian biasa
            if($question->answer == $request->answer) {
                $result = 'Y';
            } else {
                $result = 'N';
            }
            $answer_value = $request->answer; // Simpan jawaban asli yang dipilih
        }

        //get answer
        $answer = Answer::where('exam_id', $request->exam_id)
                    ->where('exam_session_id', $request->exam_session_id)
                    ->where('participant_id', auth()->guard('participant')->user()->id)
                    ->where('question_id', $request->question_id)
                    ->first();

        //update jawaban
        if($answer) {
            $answer->answer = $answer_value; // Gunakan jawaban asli
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
        $exam_group = ExamGroup::with('exam.category')->find($request->exam_group_id);
        
        //get category title
        $category_title = strtolower($exam_group->exam->category->title);
        
        //cek apakah kategori mengandung kata attitude/sikap/akhlak
        if(str_contains($category_title, 'attitude') || 
           str_contains($category_title, 'sikap') || 
           str_contains($category_title, 'akhlak')) {
            
            //ambil semua jawaban
            $answers = Answer::where('exam_id', $request->exam_id)
                        ->where('exam_session_id', $request->exam_session_id)
                        ->where('participant_id', auth()->guard('participant')->user()->id)
                        ->get();
            
            //hitung total nilai dari bobot jawaban berdasarkan pilihan
            $total_score = $answers->sum(function($answer) {
                // Ambil question untuk mendapatkan bobot
                $question = $answer->question;
                
                // Ambil weight sesuai jawaban yang dipilih
                $weight_field = 'option_' . $answer->answer . '_weight';
                
                // Return bobot sesuai pilihan, default 0 jika tidak ada bobot
                return $question->$weight_field ?? 0;
            });
            
            //hitung rata-rata dengan membagi total score dengan jumlah soal yang ditampilkan
            $average_score = round($total_score / $exam_group->exam->showqty, 2);
            
            //update nilai di table grades
            $grade = Grade::where('exam_id', $request->exam_id)
                    ->where('exam_session_id', $request->exam_session_id)
                    ->where('participant_id', auth()->guard('participant')->user()->id)
                    ->first();
            
            $grade->end_time = Carbon::now();
            $grade->total_correct = null; // total dari bobot
            $grade->grade = $average_score; // rata-rata dari bobot
            $grade->exam_type = 'ujian_attitude';
            $grade->update();
            
        } else {
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
        }

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

    /**
     * results
     *
     * @return void
     */
    public function results()
    {
        //get participant
        $participant = auth()->guard('participant')->user();
        
        //get grades with proper relationships
        $grades = Grade::with(['exam.category'])
            ->where('participant_id', $participant->id)
            ->orderBy('created_at', 'DESC')
            ->get();
            
        // Enhanced debug data
        $debugData = [
            'participant_id' => $participant->id,
            'grades_count' => $grades->count(),
            'weighted_averages' => [],
            'exam_types' => []
        ];

        //format data untuk chart
        $chartData = [
            'categories' => $grades->pluck('exam.category.title')->unique()->values(),
            'values' => []
        ];
        
        // Define weights for each exam type
        $weights = [
            'multiple_choice' => 0.35,
            'ujian_attitude' => 0.15,
            'ujian_pratik' => 0.50
        ];
        
        //hitung rata-rata nilai per kategori dan exam_type
        foreach ($chartData['categories'] as $category) {
            $categoryGrades = $grades->filter(function($grade) use ($category) {
                return $grade->exam->category->title === $category;
            });
        
            // Group by exam_type and calculate average
            $examTypeAverages = [];
            $groupedGrades = $categoryGrades->groupBy('exam_type');
            
            // Calculate averages for available exam types
            foreach ($groupedGrades as $examType => $typeGrades) {
                if ($examType === null) continue;
                
                $validGrades = $typeGrades->filter(function($grade) {
                    return $grade->grade > 0;
                });
                
                if ($validGrades->isNotEmpty() && isset($weights[$examType])) {
                    $examTypeAverages[$examType] = [
                        'average' => $validGrades->avg('grade'),
                        'weight' => $weights[$examType]
                    ];
                }
            }
            
            // Calculate weighted average for the category
            $weightedSum = 0;
            $totalWeight = 0;
            
            foreach ($examTypeAverages as $type => $data) {
                $weightedSum += $data['average'] * $data['weight'];
                $totalWeight += $data['weight'];
            }
            
            $finalAverage = $totalWeight > 0 ? $weightedSum / $totalWeight : 0;
            $chartData['values'][] = round($finalAverage, 2);
        }
        
        //format data untuk tabel
        $results = $grades->map(function($grade) {
            return [
                'exam_title' => $grade->exam->title,
                'category' => $grade->exam->category->title,
                'grade' => $grade->grade,
                'level' => $this->determineLevel($grade->grade),
                'date' => $grade->created_at->format('d/m/Y H:i')
            ];
        });
        
        //get top technicians regional and national
        $allParticipantGrades = Grade::with(['participant.area'])
            ->whereNotNull('end_time')
            ->whereNotNull('exam_type')
            ->where('grade', '>', 0)
            ->get()
            ->groupBy('participant_id')
            ->map(function($participantGrades) {
                // Group grades by exam_type
                $examTypeAverages = [];
                $grades = $participantGrades->groupBy('exam_type');
                
                // Define weights
                $weights = [
                    'multiple_choice' => 0.35,
                    'ujian_attitude' => 0.15,
                    'ujian_pratik' => 0.50
                ];
                
                // Calculate averages for each exam type
                foreach ($grades as $examType => $typeGrades) {
                    if ($examType === null) continue;
                    
                    $validGrades = $typeGrades->filter(function($grade) {
                        return $grade->grade > 0;
                    });
                    
                    if ($validGrades->isNotEmpty() && isset($weights[$examType])) {
                        $examTypeAverages[$examType] = [
                            'average' => $validGrades->avg('grade'),
                            'weight' => $weights[$examType]
                        ];
                    }
                }
                
                // Calculate weighted average - PERSIS SAMA dengan results()
                $weightedSum = 0;
                $totalWeight = 0;
                
                foreach ($examTypeAverages as $type => $data) {
                    $weightedSum += $data['average'] * $data['weight'];
                    $totalWeight += $data['weight'];
                }
                
                // Gunakan format yang sama persis dengan results()
                return [
                    'participant_id' => $participantGrades->first()->participant_id,
                    'participant' => $participantGrades->first()->participant,
                    'average_grade' => round($weightedSum, 2)
                ];
            })
            ->values();

        // Top Regional - Ambil 10 tertinggi dari area yang sama
        $topTechniciansArea = $allParticipantGrades
            ->filter(function($item) use ($participant) {
                return $item['participant']->area_id === $participant->area_id;
            })
            ->sortByDesc('average_grade')
            ->values();

        // Top National - Ambil 10 tertinggi dari semua area    
        $topTechniciansNational = $allParticipantGrades
            ->sortByDesc('average_grade')
            ->values();
        
        // Get user rankings
        $userAreaRank = $allParticipantGrades
            ->filter(function($item) use ($participant) {
                return $item['participant']->area_id === $participant->area_id;
            })
            ->sortByDesc('average_grade')
            ->search(function($item) use ($participant) {
                return $item['participant_id'] === $participant->id;
            }) + 1;
        
        $userNationalRank = $allParticipantGrades
            ->sortByDesc('average_grade')
            ->search(function($item) use ($participant) {
                return $item['participant_id'] === $participant->id;
            }) + 1;
        
        // Add more debug info before return
        $debugData['weighted_averages'] = $allParticipantGrades
            ->where('participant_id', $participant->id)
            ->first();
        
        $debugData['exam_types'] = $grades->pluck('exam_type')->unique()->values();
        
        // Ambil semua kategori ujian
        $categories = Category::all();
        
        // Tambahkan category_scores untuk setiap teknisi
        $allParticipantGrades = $allParticipantGrades->map(function($item) use ($grades) {
            // Ambil semua grade untuk participant ini
            $participantGrades = Grade::with(['exam.category'])
                ->where('participant_id', $item['participant_id'])
                ->whereNotNull('end_time')
                ->whereNotNull('exam_type')
                ->where('grade', '>', 0)
                ->get();
            
            // Hitung nilai rata-rata per kategori
            $categoryScores = [];
            $participantGrades->groupBy(function($grade) {
                return $grade->exam->category->title;
            })->each(function($grades, $categoryName) use (&$categoryScores) {
                $categoryScores[$categoryName] = $grades->avg('grade');
            });
            
            $item['category_scores'] = $categoryScores;
            return $item;
        });

        return inertia('Participant/Results/Index', [
            'results' => $results,
            'chartData' => $chartData,
            'topTechniciansArea' => $topTechniciansArea,
            'topTechniciansNational' => $topTechniciansNational,
            'topTechniciansByWitel' => $allParticipantGrades, // Kirim semua data teknisi untuk difilter di frontend
            'userAreaRank' => $userAreaRank,
            'userNationalRank' => $userNationalRank,
            'debugInfo' => $debugData,  // Changed from 'debug' to 'debugInfo'
            'categories' => $categories // Tambahkan kategori ujian
        ]);
    }

    /**
 * history
 *
 * @return void
 */
public function pengumuman(){
    return inertia('Participant/Pengumuman/Index');
}

public function history()
{
    //get participant
    $participant = auth()->guard('participant')->user();
    
    //get completed exams with relationships
    $completedExams = Grade::with(['exam.category', 'exam_session', 'exam_group.participant.area'])
        ->where('participant_id', $participant->id)
        ->where('end_time', '!=', null)
        ->get()
        ->map(function($grade) {
            return [
                'exam_group' => $grade->exam_group,
                'grade' => [
                    'end_time' => $grade->end_time,
                    'grade' => $grade->grade
                ]
            ];
        });

    //get missed exams
    $missedExams = ExamGroup::with(['exam.category', 'exam_session', 'participant.area'])
        ->where('participant_id', $participant->id)
        ->whereHas('exam_session', function($query) {
            $query->where('end_time', '<', now());
        })
        ->whereDoesntHave('grades', function($query) use ($participant) {
            $query->where('participant_id', $participant->id);
        })
        ->get()
        ->map(function($examGroup) {
            return [
                'exam_group' => $examGroup,
                'grade' => [
                    'end_time' => null,
                    'grade' => null
                ]
            ];
        });

    //gabungkan data completed dan missed exams
    $examData = $completedExams->concat($missedExams);

    return inertia('Participant/History/Index', [
        'exam_groups' => $examData,
        'auth' => [
            'participant' => $participant
        ]
    ]);
}
    
    /**
     * determineLevel
     *
     * @param float $grade
     * @return string
     */
    private function determineLevel($grade)
    {
        if ($grade >= 91) return 'Expert';
        if ($grade >= 71) return 'Advanced';
        if ($grade >= 61) return 'Intermediate';
        if ($grade >= 31) return 'Basic';
        return 'Starter';
    }

    public function technicianDetail($participant_id)
{
    // Get participant data
    $technician = \App\Models\Participant::findOrFail($participant_id);
    
    // Get grades with exam and category relationships
    $grades = \App\Models\Grade::with(['exam.category', 'exam_session'])
        ->where('participant_id', $participant_id)
        ->get();
        
    // Get categories
    $categories = \App\Models\Category::orderBy('title')->get();
    
    // Calculate scores per category
    $categoryScores = [];
    $totalScore = 0;
    $scoreCount = 0;
    
    foreach ($categories as $category) {
        $categoryGrades = $grades->filter(function($grade) use ($category) {
            return $grade->exam->category_id === $category->id;
        });
        
        if ($categoryGrades->count() > 0) {
            $avgScore = $categoryGrades->avg('grade');
            $categoryScores[$category->title] = round($avgScore, 2);
            $totalScore += $avgScore;
            $scoreCount++;
        } else {
            $categoryScores[$category->title] = 0;
        }
    }
    
    $averageGrade = $scoreCount > 0 ? round($totalScore / $scoreCount, 2) : 0;
    
    // Get area and national rankings
    $allParticipantGrades = $this->calculateAllParticipantGrades();
    
    // Filter untuk area
    $topTechniciansArea = $allParticipantGrades
        ->filter(function($item) use ($technician) {
            return $item['participant']->area_id === $technician->area_id;
        })
        ->sortByDesc('average_grade')
        ->values();
    
    // Untuk nasional (semua area)
    $topTechniciansNational = $allParticipantGrades
        ->sortByDesc('average_grade')
        ->values();
    
    $areaRank = $topTechniciansArea
        ->search(function($item) use ($participant_id) {
            return $item['participant_id'] == $participant_id;
        }) + 1;
    
    $nationalRank = $topTechniciansNational
        ->search(function($item) use ($participant_id) {
            return $item['participant_id'] == $participant_id;
        }) + 1;
        $grades = Grade::with(['exam.category'])
        ->where('participant_id', $participant_id)
        ->orderBy('created_at', 'DESC')
        ->get();
    
    // Format data untuk tabel riwayat nilai
    $results = $grades->map(function($grade) {
        return [
            'exam_title' => $grade->exam->title,
            'category' => $grade->exam->category->title,
            'grade' => $grade->grade,
            'level' => $this->determineLevel($grade->grade),
            'date' => $grade->created_at->format('d/m/Y H:i')
        ];
    });
    return inertia('Participant/Results/TechnicianDetail', [
        'technician' => $technician,
        'categories' => $categories,
        'categoryScores' => $categoryScores,
        'averageGrade' => $averageGrade,
        'areaRank' => $areaRank,
        'nationalRank' => $nationalRank,
        'topTechniciansArea' => $topTechniciansArea,
        'topTechniciansNational' => $topTechniciansNational,
        'results' => $results
    ]);
}

    private function calculateAllParticipantGrades()
    {
        return Grade::with(['participant.area'])
            ->whereNotNull('end_time')
            ->whereNotNull('exam_type')
            ->where('grade', '>', 0)
            ->get()
            ->groupBy('participant_id')
            ->map(function($participantGrades) {
                // Group grades by exam_type
                $examTypeAverages = [];
                $grades = $participantGrades->groupBy('exam_type');
                
                // Define weights
                $weights = [
                    'multiple_choice' => 0.35,
                    'ujian_attitude' => 0.15,
                    'ujian_pratik' => 0.50
                ];
                
                // Calculate averages for each exam type
                foreach ($grades as $examType => $typeGrades) {
                    if ($examType === null) continue;
                    
                    $validGrades = $typeGrades->filter(function($grade) {
                        return $grade->grade > 0;
                    });
                    
                    if ($validGrades->isNotEmpty() && isset($weights[$examType])) {
                        $examTypeAverages[$examType] = [
                            'average' => $validGrades->avg('grade'),
                            'weight' => $weights[$examType]
                        ];
                    }
                }
                
                // Calculate weighted average
                $weightedSum = 0;
                $totalWeight = 0;
                
                foreach ($examTypeAverages as $type => $data) {
                    $weightedSum += $data['average'] * $data['weight'];
                    $totalWeight += $data['weight'];
                }
                
                // Gunakan perhitungan yang sama dengan results()
                $finalAverage = $totalWeight > 0 ? $weightedSum : 0;
                
                // Return with same format as in results()
                return [
                    'participant_id' => $participantGrades->first()->participant_id,
                    'participant' => $participantGrades->first()->participant,
                    'average_grade' => round($finalAverage, 2)
                ];
            });
    }

}
