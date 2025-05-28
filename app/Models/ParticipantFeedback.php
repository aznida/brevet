<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipantFeedback extends Model
{
    use HasFactory;
    
    protected $table = 'participant_feedback';
    
    protected $fillable = [
        'exam_session_id',
        'participant_id',
        'satisfaction_rating',
        'relevance_rating',
        'comments'
    ];
    
    public function examSession()
    {
        return $this->belongsTo(ExamSession::class);
    }
    
    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
}