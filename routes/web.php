<?php

use Illuminate\Support\Facades\Route;


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

    });
});