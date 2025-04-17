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
        'area_id',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function assessments()
    {
        return $this->hasMany(PerformanceAssessmentAssignment::class, 'assessment_id');
    }
}