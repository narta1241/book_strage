<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSeries extends Model
{
    protected $fillable = ['user_id', 'series_id', 'volume'];
    
}
