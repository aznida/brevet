<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = [
        'area_id',
        'nik',
        'name',
        'password',
        'gender',
        'witel',
        'email',
        'status'
    ];

    protected $hidden = [
        'password'
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function assessorAssignments()
    {
        return $this->hasMany(PerformanceAssessmentAssignment::class, 'assessor_id');
    }

    public function assesseeAssignments()
    {
        return $this->hasMany(PerformanceAssessmentAssignment::class, 'assessee_id');
    }

    /**
     * Get the grades for the participant.
     */
    public function grades()
    {
        return $this->hasMany(Grade::class, 'participant_id');
    }

    public function exam_groups()
    {
        return $this->hasMany(ExamGroup::class, 'participant_id')->with(['exam_session', 'grades']);
    }
}