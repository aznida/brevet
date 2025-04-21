<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Participant\ExamPraktikController;


Route::get('/', function () {
    return view('welcome');
});


//prefix "admin"
Route::prefix('admin')->group(function() {

    //middleware "auth"
    Route::group(['middleware' => ['auth']], function () {

        //route dashboard
        Route::get('/dashboard', App\Http\Controllers\Admin\DashboardController::class)->name('admin.dashboard');
        
        //route resource categories    
        Route::resource('/categories', \App\Http\Controllers\Admin\CategoryController::class, ['as' => 'admin']);

        //route resource areas    
        Route::resource('/areas', \App\Http\Controllers\Admin\AreaController::class, ['as' => 'admin']);

        //route participant import
        Route::get('/participants/import', [\App\Http\Controllers\Admin\ParticipantController::class, 'import'])->name('admin.participants.import');

        //route participant store import
        Route::post('/participants/import', [\App\Http\Controllers\Admin\ParticipantController::class, 'storeImport'])->name('admin.participants.storeImport');

        //route resource participants   
        Route::resource('/participants', \App\Http\Controllers\Admin\ParticipantController::class, ['as' => 'admin']);

        //route resource exams    
        Route::resource('/exams', \App\Http\Controllers\Admin\ExamController::class, ['as' => 'admin']);

        //custom route for create question exam
        Route::get('/exams/{exam}/questions/create', [\App\Http\Controllers\Admin\ExamController::class, 'createQuestion'])->name('admin.exams.createQuestion');

        //custom route for store question exam
        Route::post('/exams/{exam}/questions/store', [\App\Http\Controllers\Admin\ExamController::class, 'storeQuestion'])->name('admin.exams.storeQuestion');
        
        //custom route for edit question exam
        Route::get('/exams/{exam}/questions/{question}/edit', [\App\Http\Controllers\Admin\ExamController::class, 'editQuestion'])->name('admin.exams.editQuestion');

        //custom route for update question exam
        Route::put('/exams/{exam}/questions/{question}/update', [\App\Http\Controllers\Admin\ExamController::class, 'updateQuestion'])->name('admin.exams.updateQuestion');
        
        //custom route for destroy question exam
        Route::delete('/exams/{exam}/questions/{question}/destroy', [\App\Http\Controllers\Admin\ExamController::class, 'destroyQuestion'])->name('admin.exams.destroyQuestion');

        //route Question import
        Route::get('/exams/{exam}/questions/import', [\App\Http\Controllers\Admin\ExamController::class, 'import'])->name('admin.exam.questionImport');

        //route Question Store import
        Route::post('/exams/{exam}/questions/import', [\App\Http\Controllers\Admin\ExamController::class, 'storeImport'])->name('admin.exam.questionStoreImport');
        
        //route resource exam_sessions    
        Route::resource('/exam_sessions', \App\Http\Controllers\Admin\ExamSessionController::class, ['as' => 'admin']);
        
        //custom route for enrolled create
        Route::get('/exam_sessions/{exam_session}/enrolled/create', [\App\Http\Controllers\Admin\ExamSessionController::class, 'createEnrolled'])->name('admin.exam_sessions.createEnrolled');

        //custom route for enrolled store
        Route::post('/exam_sessions/{exam_session}/enrolled/store', [\App\Http\Controllers\Admin\ExamSessionController::class, 'storeEnrolled'])->name('admin.exam_sessions.storeEnrolled');

        //custom route for enrolle destroy
        Route::delete('/exam_sessions/{exam_session}/enrolled/{exam_group}/destroy', [\App\Http\Controllers\Admin\ExamSessionController::class, 'destroyEnrolled'])->name('admin.exam_sessions.destroyEnrolled');

        //route index reports
        Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('admin.reports.index');

        //route index reports filter
        Route::get('/reports/filter', [\App\Http\Controllers\Admin\ReportController::class, 'filter'])->name('admin.reports.filter');

        //route index reports export
        Route::get('/reports/export', [\App\Http\Controllers\Admin\ReportController::class, 'export'])->name('admin.reports.export');

        //route resource performance_assessments    
        Route::resource('/performance_assessments', \App\Http\Controllers\Admin\PerformanceAssessmentController::class, ['as' => 'admin']);

        //custom route for assign assessor
        Route::get('/performance_assessments/{assessment}/assign', [\App\Http\Controllers\Admin\PerformanceAssessmentController::class, 'assign'])->name('admin.performance_assessments.assign');

        //custom route for store assessor
        Route::post('/performance_assessments/{assessment}/store-assessor', [\App\Http\Controllers\Admin\PerformanceAssessmentController::class, 'storeAssessor'])->name('admin.performance_assessments.storeAssessor');

        //delete assignment route
        Route::delete('/performance_assessments/{assessment}/assignments/{assignment}', [\App\Http\Controllers\Admin\PerformanceAssessmentAssignmentController::class, 'destroy'])->name('admin.performance-assessments.assignments.destroy');
        
        //update assignment
        Route::put('/performance_assessments/{assessment}/assignments/{assignment}', [\App\Http\Controllers\Admin\PerformanceAssessmentAssignmentController::class, 'update'])->name('admin.performance-assessments.assignments.update');
    });
    //route pending exams
    Route::get('/pending-exams', [\App\Http\Controllers\Admin\PendingExamController::class, 'index'])
        ->name('admin.pending-exams.index');
    Route::get('/pending-exams/export', [\App\Http\Controllers\Admin\PendingExamController::class, 'export'])
        ->name('admin.pending-exams.export');
});

//route homepage
Route::get('/', function () {

    //cek session participant
    if(auth()->guard('participant')->check()) {
        return redirect()->route('participant.dashboard');
    }

    //return view login
    return \Inertia\Inertia::render('Participant/Login/Index');
});

//login participants
Route::post('/participants/login', \App\Http\Controllers\Participant\LoginController::class)->name('participant.login');

//prefix "participant"
Route::prefix('participant')->group(function() {

    //middleware "participant"
    Route::group(['middleware' => 'participant'], function () {
        
        //route dashboard
        Route::get('/dashboard', App\Http\Controllers\Participant\DashboardController::class)->name('participant.dashboard');
        
        //route exam confirmation
        Route::get('/exam-confirmation/{id}', [App\Http\Controllers\Participant\ExamController::class, 'confirmation'])->name('participant.exams.confirmation');
        
        //route exam start
        Route::get('/exam-start/{id}', [App\Http\Controllers\Participant\ExamController::class, 'startExam'])->name('participant.exams.startExam');
        
        //route exam show
        Route::get('/exam/{id}/{page}', [App\Http\Controllers\Participant\ExamController::class, 'show'])->name('participant.exams.show');
        
        //route exam update duration
        Route::put('/exam-duration/update/{grade_id}', [App\Http\Controllers\Participant\ExamController::class, 'updateDuration'])->name('participant.exams.update_duration');
        
        //route answer question
        Route::post('/exam-answer', [App\Http\Controllers\Participant\ExamController::class, 'answerQuestion'])->name('participant.exams.answerQuestion');

        //route exam end
        Route::post('/exam-end', [App\Http\Controllers\Participant\ExamController::class, 'endExam'])->name('participant.exams.endExam');
        
        //route exam result
        Route::get('/exam-result/{exam_group_id}', [App\Http\Controllers\Participant\ExamController::class, 'resultExam'])->name('participant.exams.resultExam');
    
        //route performance assessment list
        Route::get('/performance-assessments', [App\Http\Controllers\Participant\PerformanceAssessmentController::class, 'index'])->name('participant.performance_assessments.index');
    
        //route performance assessment show
        Route::get('/admin/performance_assessments/{id}', [PerformanceAssessmentController::class, 'show'])
            ->name('admin.performance-assessments.show');
    
        //route performance assessment submit
        Route::post('/performance-assessments/{assessment}/submit', [App\Http\Controllers\Participant\PerformanceAssessmentController::class, 'submit'])->name('participant.performance_assessments.submit');

    });
});
