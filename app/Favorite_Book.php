<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite_Book extends Model
{
     use \LaravelTreats\Model\Traits\HasCompositePrimaryKey;
    
    public $incrementing = false;
    
    protected $primaryKey = ['user_id', 'book_id'];
    
    protected $fillable = ['user_id', 'book_id'];
    
    protected $table = 'favorite_books';
   
    public $timestamps = false;
}
