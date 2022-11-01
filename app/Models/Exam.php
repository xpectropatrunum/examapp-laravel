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
    public function key()
    {
        return $this->hasOne(ExamKey::class);
    }
    public function users()
    {
        return $this->hasMany(ExamUser::class, "exam_id", "id");
    }
    public function file()
    {
        return $this->hasOne(ExamFile::class);
    }
    public function sessions()
    {
        return $this->hasMany(ExamSession::class);
    }
    public function getImageAttribute()
    {
        $id = $this->attributes["id"];
        try{
            if(file_get_contents(public_path(). "/exams/" . md5($id) . ".png") > 0){}
            return env("APP_URL") . "/exams/" . md5($id) . ".png";
        }catch(\Exception $e){
            return env("APP_URL") . "/exams/default.png";
        }

    }
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
