<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Expert extends Authenticatable
{

    protected $fillable = [
        'name',
        'phone',
        'is_active',
        'password',
    ];
   
    public function users()
    {
        return $this->belongsToMany(User::class, ExpertUser::class);
    }
  
    
}
