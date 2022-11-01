<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ExamSessionAnswer extends Model
{
    public $table = "exam_session_answers";

    protected $fillable = [
        'exam_session_id',
        'q',
        'a',
    ];


}
