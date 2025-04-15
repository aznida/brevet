<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PerformanceAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'area_id',  // Add this
        'start_date',
        'end_date'
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function questions()
    {
        return $this->hasMany(PerformanceQuestion::class);
    }

    public function assessors()
    {
        return $this->belongsToMany(Participant::class, 'performance_assessment_assignments', 'assessment_id', 'assessor_id')
            ->withPivot(['assessee_id', 'status']);
    }

    public function assessments()
    {
        return $this->hasMany(PerformanceAssessmentAssignment::class);
    }

    public function answers()
    {
        return $this->hasMany(PerformanceAnswer::class);
    }
}