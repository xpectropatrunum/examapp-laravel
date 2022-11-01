<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Exam extends Model
{

    protected $fillable = [
        'title',
        'type',
        'q_number',
        'q_time',
        'description',
        'neg_score',
        'is_active',
    ];
    public function key(){
        return $this->hasOne(ExamKey::class);
    }
    public function users(){
        return $this->hasMany(ExamUser::class, "exam_id", "id");
    }
    public function file(){
        return $this->hasOne(ExamFile::class);
    }
 protected $casts = [
        'email_verified_at' => 'datetime',
    ];
   
}
