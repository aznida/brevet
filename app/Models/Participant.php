<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Participant extends Authenticatable
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'area_id',
        'nik',
        'name',
        'email',
        'hp',
        'witel',
        'password',
        'gender',
        'status',
        'role',
    ];

    /**
     * classroom
     *
     * @return void
     */
    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    /**
     * Get the grades for the participant.
     */
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}