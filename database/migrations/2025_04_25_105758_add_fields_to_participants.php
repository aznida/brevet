<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->string('masa_kerja')->nullable();
            $table->date('tanggal_lahir')->nullable();
        });
    }

    public function down()
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->dropColumn(['masa_kerja', 'tanggal_lahir']);
        });
    }
};