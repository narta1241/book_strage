<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use App\BookSearch;
use App\Series;
use DateTime;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user_series()
    {
        return $this->hasOne('App\UserSeries');
    }

    public function series_review()
    {
        return $this->hasmany('App\SeriesReview');
    }

    public function countVolume()
    {
        $num = $this->user_series()->where('user_id', Auth::id())->count();

        return $num;
    }

    public function sumVolume()
    {
        $sum = $this->user_series()->where('user_id', Auth::id())->sum('volume');

        return $sum;
    }

    public function reviewCount()
    {
        $num = $this->series_review()->where('user_id', Auth::id())->count();

        return $num;
    }

    public function checkuser($series)
    {
        $user = $this->user_series()->where('user_id', Auth::id())->where('series_id', $series)->first();

        return $user;
    }

    public static function getSalesDate()
    {
        $Owned_book = UserSeries::where('user_id', Auth::id())->pluck('series_id');
        $seriesList = Series::whereIn('id', $Owned_book)->where('final_flg', 0)->orderBy('created_at', 'desc')->get();

        $today = date('Y/m/d');
        $today = new DateTime($today);

        foreach ($seriesList as $series) {
            $salesDay = preg_replace('/[^0-9]/', '', $series->salesDate);
            if ($salesDay) {
                $salesDay = new Datetime($salesDay);
            }

            if (!$salesDay || $salesDay < $today) {
                $series->salesDate = BookSearch::saleDaySearch($series->title);
                $newSalesDay = preg_replace('/[^0-9]/', '', $series->salesDate);
                $newSalesDay = new Datetime($newSalesDay);
                if ($newSalesDay > $today) {
                    $series->save();
                }
            }
        }
    }
}
