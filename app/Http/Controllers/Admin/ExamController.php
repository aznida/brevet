<?php

namespace App\Http\Controllers\Admin;

use App\Models\Exam;
use App\Models\Category;
use App\Models\Area;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\QuestionsImport;
use Maatwebsite\Excel\Facades\Excel;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get exams
        $exams = Exam::when(request()->q, function($exams) {
            $exams = $exams->where('title', 'like', '%'. request()->q . '%');
        })->with('category', 'area', 'questions')->latest()->paginate(5);

        //append query string to pagination links
        $exams->appends(['q' => request()->q]);

        //render with inertia
        return inertia('Admin/Exams/Index', [
            'exams' => $exams,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //get categorys
        $categories = Category::all();

        //get areas
        $areas = Area::all();
        
        //render with inertia
        return inertia('Admin/Exams/Create', [
            'categories' => $categories,
            'areas' => $areas,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate request
        $request->validate([
            'title'             => 'required',
            'category_id'       => 'required|integer',
            'area_id'          => 'required|integer',
            'duration'          => 'required|integer',
            'showqty'          => 'required|integer',
            'description'       => 'required',
            'random_question'   => 'required',
            'random_answer'     => 'required',
            'show_answer'       => 'required',
            // 'exam_type'         => 'required|in:multiple_choice,rating_scale',  // Add validation
        ]);

        //create exam
        Exam::create([
            'title'             => $request->title,
            'category_id'       => $request->category_id,
            'area_id'          => $request->area_id,
            'duration'          => $request->duration,
            'showqty'          => $request->showqty,
            'description'       => $request->description,
            'random_question'   => $request->random_question,
            'random_answer'     => $request->random_answer,
            'show_answer'       => $request->show_answer,
            'exam_type'         => $request->exam_type,  // Add this line
        ]);

        //redirect
        return redirect()->route('admin.exams.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //get exam
        $exam = Exam::with(['category', 'area'])->findOrFail($id);
    
        //get relation questions with pagination based on exam type
        $questions = $exam->questions()
            ->when($exam->exam_type === 'multiple_choice', function($query) {
                return $query->select('id', 'exam_id', 'question', 'question_type', 
                    'option_1', 'option_2', 'option_3', 'option_4', 'option_5', 
                    'option_1_weight', 'option_2_weight', 'option_3_weight', 'option_4_weight', 'option_5_weight',
                    'answer', 'level');
            })
            ->when($exam->exam_type === 'rating_scale', function($query) {
                return $query->select('id', 'exam_id', 'question', 'question_type', 'rating_scale');
            })
            ->where('question_type', $exam->exam_type)
            ->paginate(20);
    
        //set relation
        $exam->setRelation('questions', $questions);
    
        //render with inertia
        return inertia('Admin/Exams/Show', [
            'exam' => $exam,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Exam $exam)
    {
        // Load the exam with its relationships and ensure exam_type is included
        $exam->load(['category', 'area']);
        
        return inertia('Admin/Exams/Edit', [
            'exam' => array_merge($exam->toArray(), [
                'exam_type' => $exam->exam_type ?? 'multiple_choice' // Provide default if not set
            ]),
            'categories' => Category::all(),
            'areas' => Area::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exam $exam)
    {
        //validate request
        $request->validate([
            'title'             => 'required',
            'category_id'       => 'required|integer',
            'area_id'          => 'required|integer',
            'duration'          => 'required|integer',
            'showqty'          => 'required|integer',
            'description'       => 'required',
            'random_question'   => 'required',
            'random_answer'     => 'required',
            'show_answer'       => 'required',
            // 'exam_type'         => 'required|in:multiple_choice,rating_scale',  // Add validation
        ]);

        //update exam
        $exam->update([
            'title'             => $request->title,
            'category_id'       => $request->category_id,
            'area_id'          => $request->area_id,
            'duration'          => $request->duration,
            'showqty'          => $request->showqty,
            'description'       => $request->description,
            'random_question'   => $request->random_question,
            'random_answer'     => $request->random_answer,
            'show_answer'       => $request->show_answer,
            'exam_type'         => $request->exam_type,  // Add this line
        ]);

        //redirect
        return redirect()->route('admin.exams.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //get exam
        $exam = Exam::findOrFail($id);

        //delete exam
        $exam->delete();

        //redirect
        return redirect()->route('admin.exams.index');
    }

    /**
     * createQuestion
     *
     * @param  mixed $exam
     * @return void
     */
    public function createQuestion(Exam $exam)
    {
        //render with inertia
        return inertia('Admin/Questions/Create', [
            'exam' => $exam,
        ]);
    }
    /**
     * storeQuestion
     *
     * @param  mixed $request
     * @param  mixed $exam
     * @return void
     */
    public function storeQuestion(Request $request, Exam $exam)
    {
        try {
            // Base validation rules
            $rules = [
                'question' => 'required',
            ];
    
            // Add validation rules based on exam type
            if ($exam->exam_type === 'multiple_choice') {
                $rules = array_merge($rules, [
                    'option_1' => 'required',
                    'option_2' => 'required',
                    'option_3' => 'required',
                    'option_4' => 'required',
                    'option_5' => 'required',
                    'answer' => str_contains(strtolower($exam->title), 'attitude') || 
                               str_contains(strtolower($exam->title), 'sikap') || 
                               str_contains(strtolower($exam->title), 'akhlak') ? 'nullable' : 'required',
                    'level' => 'required',
                ]);
            }
    
            $request->validate($rules);
    
            // Extract question content
            $questionContent = $request->question['ops'][0]['insert'] ?? $request->question;
    
            // Base question data
            $questionData = [
                'exam_id' => $exam->id,
                'question' => $questionContent,
                'question_type' => $exam->exam_type,
            ];
    
            // Add type-specific data
            if ($exam->exam_type === 'multiple_choice') {
                $questionData = array_merge($questionData, [
                    'option_1' => $request->option_1['ops'][0]['insert'] ?? $request->option_1,
                    'option_2' => $request->option_2['ops'][0]['insert'] ?? $request->option_2,
                    'option_3' => $request->option_3['ops'][0]['insert'] ?? $request->option_3,
                    'option_4' => $request->option_4['ops'][0]['insert'] ?? $request->option_4,
                    'option_5' => $request->option_5['ops'][0]['insert'] ?? $request->option_5,
                    'option_1_weight' => $request->filled('option_1_weight') ? $request->option_1_weight : null,
                    'option_2_weight' => $request->filled('option_2_weight') ? $request->option_2_weight : null,
                    'option_3_weight' => $request->filled('option_3_weight') ? $request->option_3_weight : null,
                    'option_4_weight' => $request->filled('option_4_weight') ? $request->option_4_weight : null,
                    'option_5_weight' => $request->filled('option_5_weight') ? $request->option_5_weight : null,
                    'answer' => $request->answer,
                    'level' => $request->level,
                    'rating_scale' => null
                ]);
            } else {
                $questionData = array_merge($questionData, [
                    'option_1' => null,
                    'option_2' => null,
                    'option_3' => null,
                    'option_4' => null,
                    'option_5' => null,
                    'option_1_weight' => null,
                    'option_2_weight' => null,
                    'option_3_weight' => null,
                    'option_4_weight' => null,
                    'option_5_weight' => null,
                    'answer' => null,  // Allowed to be null for rating_scale
                    'level' => null,
                    'rating_scale' => 6
                ]);
            }
    
            Question::create($questionData);
            return redirect()->route('admin.exams.show', $exam->id);
            
        } catch (\Exception $e) {
            \Log::error('Error creating question: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to create question: ' . $e->getMessage()]);
        }
    }
    /**
     * editQuestion
     *
     * @param  mixed $exam
     * @param  mixed $question
     * @return void
     */
    public function editQuestion(Exam $exam, Question $question)
    {
        // Load the exam with its type
        $exam->load(['category', 'area']);
        
        return inertia('Admin/Questions/Edit', [
            'exam' => $exam,
            'question' => $question,
        ]);
    }
    /**
     * updateQuestion
     *
     * @param  mixed $request
     * @param  mixed $exam
     * @param  mixed $question
     * @return void
     */
    public function updateQuestion(Request $request, Exam $exam, Question $question)
    {
        try {
            // Base validation rules
            $rules = [
                'question' => 'required',
            ];
    
            // Add validation rules based on exam type
            if ($exam->exam_type === 'multiple_choice') {
                $rules = array_merge($rules, [
                    'option_1' => 'required',
                    'option_2' => 'required',
                    'option_3' => 'required',
                    'option_4' => 'required',
                    'option_5' => 'required',
                    'answer' => str_contains(strtolower($exam->title), 'attitude') || 
                               str_contains(strtolower($exam->title), 'sikap') || 
                               str_contains(strtolower($exam->title), 'akhlak') ? 'nullable' : 'required',
                    'level' => 'required',
                ]);
            }
    
            $request->validate($rules);
    
            // Extract content from Quill editor data - FIXED VERSION
            $questionContent = is_array($request->question) ? 
                json_encode($request->question) : $request->question;
    
            // Base update data
            $updateData = [
                'question' => $questionContent,
                'question_type' => $exam->exam_type
            ];
    
            // Add type-specific data
            if ($exam->exam_type === 'multiple_choice') {
                $updateData = array_merge($updateData, [
                    'option_1' => is_array($request->option_1) ? json_encode($request->option_1) : $request->option_1,
                    'option_2' => is_array($request->option_2) ? json_encode($request->option_2) : $request->option_2,
                    'option_3' => is_array($request->option_3) ? json_encode($request->option_3) : $request->option_3,
                    'option_4' => is_array($request->option_4) ? json_encode($request->option_4) : $request->option_4,
                    'option_5' => is_array($request->option_5) ? json_encode($request->option_5) : $request->option_5,
                    'option_1_weight' => $request->filled('option_1_weight') ? $request->option_1_weight : null,
                    'option_2_weight' => $request->filled('option_2_weight') ? $request->option_2_weight : null,
                    'option_3_weight' => $request->filled('option_3_weight') ? $request->option_3_weight : null,
                    'option_4_weight' => $request->filled('option_4_weight') ? $request->option_4_weight : null,
                    'option_5_weight' => $request->filled('option_5_weight') ? $request->option_5_weight : null,
                    'answer' => $request->answer,
                    'level' => $request->level,
                    'rating_scale' => null
                ]);
            } else {
                $updateData = array_merge($updateData, [
                    'option_1' => null,
                    'option_2' => null,
                    'option_3' => null,
                    'option_4' => null,
                    'option_5' => null,
                    'option_1_weight' => null,
                    'option_2_weight' => null,
                    'option_3_weight' => null,
                    'option_4_weight' => null,
                    'option_5_weight' => null,
                    'answer' => null,
                    'level' => null,
                    'rating_scale' => 6
                ]);
            }
    
            $question->update($updateData);
            return redirect()->route('admin.exams.show', $exam->id);
            
        } catch (\Exception $e) {
            \Log::error('Error updating question: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to update question: ' . $e->getMessage()]);
        }
    }

    /**
     * destroyQuestion
     *
     * @param  mixed $exam
     * @param  mixed $question
     * @return void
     */
    public function destroyQuestion(Exam $exam, Question $question)
    {
        //delete question
        $question->delete();
        
        //redirect
        return redirect()->route('admin.exams.show', $exam->id);
    }
    /**
     * import
     *
     * @return void
     */
    public function import(Exam $exam)
    {
        return inertia('Admin/Questions/Import', [
            'exam' => $exam
        ]);
    }
    
    /**
     * storeImport
     *
     * @param  mixed $request
     * @return void
     */
    public function storeImport(Request $request, Exam $exam)
    {
        // Validate if exam type is multiple choice
        if ($exam->exam_type !== 'multiple_choice') {
            return back()->withErrors(['error' => 'Import is only available for multiple choice questions.']);
        }

        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        // Import data with exam context
        Excel::import(new QuestionsImport($exam), $request->file('file'));

        //redirect
        return redirect()->route('admin.exams.show', $exam->id);
    }

}