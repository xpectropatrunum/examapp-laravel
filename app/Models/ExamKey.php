<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ExamKey extends Model
{

    protected $fillable = [
        'exam_id',
        'keys',
     
    ];
   
    protected $casts = [
        'keys' => 'array',
    ];
   
}
