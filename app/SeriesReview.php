<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeriesReview extends Model
{
    use \LaravelTreats\Model\Traits\HasCompositePrimaryKey;

    public $incrementing = false;

    protected $primaryKey = ['user_id', 'series_id'];

    protected $fillable = ['user_id', 'series_id', 'comment', 'star'];

    protected $table = 'series_reviews';

    public $timestamps = false;

    const STAR1 = '⭐️';
    const STAR2 = '⭐️⭐';
    const STAR3 = '⭐️⭐️⭐';
    const STAR4 = '⭐️⭐️⭐️⭐';
    const STAR5 = '⭐️⭐️⭐️⭐️⭐';

    public static function star_list()
    {
        return [
            1 => self::STAR1,
            2 => self::STAR2,
            3 => self::STAR3,
            4 => self::STAR4,
            5 => self::STAR5,
        ];
    }

    public function star()
    {
        $status = "";
        switch ($this->star) {
            case 1:
                $status = self::STAR1;
                break;
            case 2:
                $status = self::STAR2;
                break;
            case 3:
                $status = self::STAR3;
                break;
            case 4:
                $status = self::STAR4;
                break;
            case 5:
                $status = self::STAR5;
                break;
        }
        return $status;
    }

    public function series()
    {
        return $this->belongsTo('App\Series');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function userName($userId)
    {
        $name = $this->user()->where('id', $userId)->value('name');
        return $name;
    }
}
