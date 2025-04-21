<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->decimal('option_1_weight', 5, 2)->nullable();
            $table->decimal('option_2_weight', 5, 2)->nullable();
            $table->decimal('option_3_weight', 5, 2)->nullable();
            $table->decimal('option_4_weight', 5, 2)->nullable();
            $table->decimal('option_5_weight', 5, 2)->nullable();
        });
    }

    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn([
                'option_1_weight',
                'option_2_weight',
                'option_3_weight',
                'option_4_weight',
                'option_5_weight'
            ]);
        });
    }
};