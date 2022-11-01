<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ExamUser extends Model
{

    protected $fillable = [
        'exam_id',
        'user_id',
     
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function exam(){
        return $this->hasOne(User::class);
    }
   
   
   
}
