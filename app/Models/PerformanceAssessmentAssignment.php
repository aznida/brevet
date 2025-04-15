<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerformanceAssessmentAssignment extends Model
{
    protected $fillable = ['assessment_id', 'assessor_id', 'assessee_id', 'status'];
}