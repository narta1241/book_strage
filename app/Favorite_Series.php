<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite_Series extends Model
{
     use \LaravelTreats\Model\Traits\HasCompositePrimaryKey;
    
    public $incrementing = false;
    
    protected $primaryKey = ['user_id', 'series_id'];
    
    protected $fillable = ['user_id', 'series_id'];
     
    protected $table = 'favorite_series';
   
    public $timestamps = false;
}
