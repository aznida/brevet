<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PerformanceAssessmentAssignment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'assessment_id',
        'assessor_id',
        'assessee_id',
        'status'
    ];

    protected $with = ['assessor', 'assessee']; // Auto-load these relationships

    public function assessment()
    {
        return $this->belongsTo(PerformanceAssessment::class, 'assessment_id');
    }

    public function assessor()
    {
        return $this->belongsTo(Participant::class, 'assessor_id');
    }

    public function assessee()
    {
        return $this->belongsTo(Participant::class, 'assessee_id');
    }
}