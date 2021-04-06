<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FavoriteSeries extends Model
{
    use \LaravelTreats\Model\Traits\HasCompositePrimaryKey;

    public $incrementing = false;

    protected $primaryKey = ['user_id', 'series_id'];

    protected $fillable = ['user_id', 'series_id'];

    public $timestamps = false;
}
