<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'kota',
    ];

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    public function performanceAssessments()
    {
        return $this->hasMany(PerformanceAssessment::class);
    }
}
