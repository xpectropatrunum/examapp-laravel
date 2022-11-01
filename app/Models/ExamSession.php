<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ExamSession extends Model
{

    protected $fillable = [
        'exam_id',
        'user_id',
        'started_at',
        'status',
        'ends_in',
        'q_time'
     
    ];
    function user(){
        return $this->belongsTo(User::class);
    }
    function exam(){
        return $this->belongsTo(Exam::class);
    }
    function answers(){
        return $this->hasMany(ExamSessionAnswer::class, "exam_session_id", "id");
    }
    function getCompletedAttribute(){
        $attr = $this->attributes;
        if($attr["completed"] == 1){
            return 1;
        }
        return (time() - $attr["ends_in"] > $attr["q_time"]) ? 1 : 0;
    }

}
