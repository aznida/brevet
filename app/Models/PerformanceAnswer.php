<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerformanceAnswer extends Model
{
    protected $fillable = ['assessment_id', 'assessor_id', 'question_id', 'rating'];
}