<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    const STATUS_FINAL = "完結";
    const STATUS_CONTINUE = "続刊";
    
    protected $fillable = ['user_id', 'title', 'author', 'publisher', 'current_volume', 'final_flg'];
    
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
    
    public function book()
    {
        return $this->hasMany('App\Book');
    }
   
   public function favorite_series()
    {
        return $this->hasMany('App\Favorite_Series');
    }
}
