<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class UserImage extends Model
{
  public $timestamps = false;

    protected $fillable = [
        'user_id',
        'url',
    ];

   
}
