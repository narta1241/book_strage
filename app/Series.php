<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use RakutenRws_Client;
use DateTime;

class Series extends Model
{
    const STATUS_FINAL = "完結";
    const STATUS_CONTINUE = "続刊";

    protected $fillable = ['user_id', 'title', 'image', 'author', 'publisher', 'current_volume', 'final_flg'];

    public static function status_list()
    {
        return [
            0 => self::STATUS_CONTINUE,
            1 => self::STATUS_FINAL,
        ];
    }

    public function status()
    {
        $status = "";
        switch ($this->final_flg) {
            case 0:
                $status = self::STATUS_CONTINUE;
                break;
            case 1:
                $status = self::STATUS_FINAL;
                break;
        }

        return $status;
    }

    public function favorite_series()
    {
        return $this->hasMany('App\FavoriteSeries');
    }

    public function user_series()
    {
        return $this->hasMany('App\UserSeries');
    }

    public function series_reviews()
    {
        return $this->hasMany('App\SeriesReview');
    }


    public function checkuser($series)
    {
        $user = $this->user_series()->where('user_id', Auth::id())->where('series_id', $series)->first();

        return $user;
    }

    public function reviewsearch($series)
    {
        $review = $this->series_reviews()->where('user_id', Auth::id())->where('series_id', $series)->first();

        return $review;
    }

    public function conversion($d)
    {
        $day = preg_replace('/[^0-9]/', '', $d);
        $day = new Datetime($day);
        $day = $day->format('n');
        return $day;
    }
}

