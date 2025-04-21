<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Participant extends Authenticatable
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nik',
        'name',
        'password',
        'area_id',
        'witel',
        'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * area
     *
     * @return void
     */
    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    /**
     * grades
     *
     * @return void
     */
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}