<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Series_Review extends Model
{
    use \LaravelTreats\Model\Traits\HasCompositePrimaryKey;
    
    public $incrementing = false;
    
    protected $primaryKey = ['user_id', 'series_id'];
    
    protected $fillable = ['user_id', 'series_id', 'comment', 'star'];
    
    protected $table = 'series_reviews';
    
    public $timestamps = false;
    
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
}
