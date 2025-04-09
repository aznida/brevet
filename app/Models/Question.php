<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'question',
        'question_type',
        'option_1',
        'option_2',
        'option_3',
        'option_4',
        'option_5',
        'answer',
        'level',
        'rating_scale'
    ];

    protected $attributes = [
        'rating_scale' => 6, // Default value for rating scale
        'question_type' => 'multiple_choice' // Default question type
    ];

    protected $casts = [
        'rating_scale' => 'integer'
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function responses()
    {
        return $this->hasMany(RatingResponse::class);
    }

    public function isRatingScale()
    {
        return $this->question_type === 'rating_scale';
    }

    public function isMultipleChoice()
    {
        return $this->question_type === 'multiple_choice';
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($question) {
            if ($question->isRatingScale()) {
                $question->option_1 = null;
                $question->option_2 = null;
                $question->option_3 = null;
                $question->option_4 = null;
                $question->option_5 = null;
                $question->answer = null;
                $question->level = null;
                $question->rating_scale = 6;
            }
        });
    }
}
