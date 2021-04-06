<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeriesReview extends Model
{
    use \LaravelTreats\Model\Traits\HasCompositePrimaryKey;

    public $incrementing = false;

    protected $primaryKey = ['user_id', 'series_id'];

    protected $fillable = ['user_id', 'series_id', 'comment', 'star'];

    public $timestamps = false;

    public function series()
    {
        return $this->belongsTo('App\Series');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function user_name()
    {
        // TODO: 無駄なことをしてしまっています（ユーザー情報をすでに取得しているのに再度user_idでユーザー情報を取得している）
        // $name = $this->user()->where('id', $userId)->value('name');
        return $this->user()->name;
    }


    // public function seriesTitle($seriesId)
    // {
    //     // dump($seriesId);
    //     $title = $this->series()->where('id',$seriesId)->value('title');

    //     // dd($title);
    //     return $title;
    // }
}
