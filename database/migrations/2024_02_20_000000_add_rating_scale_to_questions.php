<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            if (!Schema::hasColumn('questions', 'question_type')) {
                $table->enum('question_type', ['multiple_choice', 'rating_scale'])
                    ->default('multiple_choice')
                    ->after('question');
            }
            
            if (!Schema::hasColumn('questions', 'rating_scale')) {
                $table->integer('rating_scale')->nullable()->after('answer');
            }
        });
    }

    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn(['question_type', 'rating_scale']);
        });
    }
};