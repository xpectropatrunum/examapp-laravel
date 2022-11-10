<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ExamAnswerFile extends Model
{

    protected $fillable = [
        'exam_id',
        'url',
     
    ];
   

   
}
