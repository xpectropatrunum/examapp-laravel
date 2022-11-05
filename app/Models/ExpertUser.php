<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ExpertUser extends Model
{

    protected $fillable = [
        'expert_id',
        'user_id',
     
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function expert(){
        return $this->hasOne(Expert::class);
    }
   
   
   
}
