<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'category_id',
        'area_id',
        'duration',
        'description',
        'random_question',
        'random_answer',
        'show_answer',
        'exam_type',
    ];

    /**
     * lesson
     *
     * @return void
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

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
     * questions
     *
     * @return void
     */
    public function questions()
    {
        return $this->hasMany(Question::class)->orderBy('id', 'DESC');
    }
}
