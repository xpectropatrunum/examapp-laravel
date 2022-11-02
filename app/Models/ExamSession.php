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
        'q_time',
        'completed'
     
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
    function report(){
        return $this->hasOne(Report::class);
    }
    function getCompletedAttribute(){
        $attr = $this->attributes;
        if($attr["completed"] == 1){
            return 1;
        }
        return (time() > $attr["ends_in"]) ? 1 : 0;
    }

}
