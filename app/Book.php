<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['user_id', 'series_id', 'volume'];
    
    
    
    public function series()
    {
        return $this->belongsTo('App\Series');
    }
    public function seriesTitle($seriesId)
    {
        // dump($seriesId);
        $title = $this->series()->where('id',$seriesId)->value('title');
        // dd($title);
        return $title;
    }
    public function favorite_books()
    {
        return $this->hasMany('App\Favorite_Book');
    }
}
