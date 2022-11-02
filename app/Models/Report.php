<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Report extends Model
{

    protected $fillable = [
        'user_id',
        'exam_session_id',
        'exam_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
    public function session()
    {
        return $this->belongsTo(ExamSession::class);
    }
    
}
