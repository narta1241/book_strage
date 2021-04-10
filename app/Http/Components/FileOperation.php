<?php

namespace App\Http\Components;

use App\UserSeries;
use App\Series;
use DateTime;
use App\BookSearch;
use Illuminate\Support\Facades\Auth;

class FileOperation
{
    /**
     * テキストファイルを作成する
     * @return string
     */
    public function makeTextFile()
    {
        $file = sprintf('%s/test.txt', storage_path('texts'));
        if(file_exists($file)) unlink($file);
        touch($file);
        return $file;
    }

    /**
     * ファイルに指定回数分の追加書き込みを行う
     * @param string $file
     * @param int $max
     */
    public function write(string $file, int $max)
    {
        for($i=0; $i< $max; $i++ ) {
            $current = file_get_contents($file);
            $current .= $i;
            file_put_contents($file, $current);
        }
    }
   
    public function getSalesDate()
    {
        $Owned_book = UserSeries::where('user_id', Auth::id())->pluck('series_id');
        $serieslist = Series::whereIn('id', $Owned_book)->where('final_flg', 0)->orderBy('created_at','desc')->get();
        $today = date('Y/m/d');
        $today = new DateTime($today);
        
        foreach($serieslist as $series){
            $salesDay = preg_replace('/[^0-9]/', '', $series->salesDate);
            
            if($salesDay){
                $salesDay =new Datetime($salesDay);
            }
            if(!$salesDay || $salesDay < $today){
                $series->salesDate = BookSearch::saleDaySearch($series->title);
                $newSalesDay = preg_replace('/[^0-9]/', '', $series->salesDate);
                $newSalesDay = new Datetime($newSalesDay);
                if($newSalesDay>$today){
                    $series->save();
                }
            }
            
        }
    }
}