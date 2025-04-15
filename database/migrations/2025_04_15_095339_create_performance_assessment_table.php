<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('performance_assessments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('area_id')->constrained('areas');  // Add this line
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
        });

        Schema::create('performance_questions', function (Blueprint $table) {
            $table->id();
            $table->text('question');
            $table->integer('max_rating')->default(6);
            $table->string('category')->nullable(); // e.g., 'leadership', 'teamwork', etc.
            $table->timestamps();
        });

        Schema::create('performance_assessment_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained('performance_assessments');
            $table->foreignId('assessor_id')->constrained('participants');
            $table->foreignId('assessee_id')->constrained('participants');
            $table->string('status')->default('pending');
            $table->timestamps();
        });

        Schema::create('performance_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained('performance_assessments');
            $table->foreignId('assessor_id')->constrained('participants');
            $table->foreignId('question_id')->constrained('performance_questions');
            $table->integer('rating');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('performance_answers');
        Schema::dropIfExists('performance_assessment_assignments');
        Schema::dropIfExists('performance_questions');
        Schema::dropIfExists('performance_assessments');
    }
};