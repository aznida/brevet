<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
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
        'password',
        'gender'
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
}
