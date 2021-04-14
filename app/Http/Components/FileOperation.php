<?php

namespace App\Http\Components;

use App\UserSeries;
use App\Series;
use DateTime;
use App\BookSearch;
use RakutenRws_Client;
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
    public function write(string $file,string $title)
    {
        $current = file_get_contents($file);
        $current .= $title;
        file_put_contents($file, $current);
    }
    public function changeDay($day)
    {
        $salesDay =new DateTime($day);
        return $salesDay;
    }
    public function save($day, $series_id)
    {
        $series = Series::where('id', $series_id)->first();
        $series->salesDate = $day;
        $series->save();
    }
   
    public function getBookSearch($title, $author)
    {
        // dd($keyword);
        $client = new RakutenRws_Client();
         //定数化
        if (!defined('RAKUTEN_APPLICATION_ID')){
            define("RAKUTEN_APPLICATION_ID"     , config('app.rakuten_id'));
            define("RAKUTEN_APPLICATION_SEACRET", config('app.rakuten_key'));
        } 

        //アプリIDをセット！
        $client->setApplicationId(RAKUTEN_APPLICATION_ID);
        
        if(!empty($title)){ 
            $response = $client->execute('BooksBookSearch', array(
            //入力パラメーター
                'title' => $title,
                'author' => $author,
                'sort' => '-releaseDate',
                'hits' => '1',
            // 'keyword' => $keyword,
        ));

            }
            if ($response->isOk()) {
            foreach ($response as $item){
                $saleslist = $item['salesDate'];
            }
         }else {
            echo 'Error:'.$response->getMessage();
        }
        // $newSalesDay = preg_replace('/[^0-9]/', '', $saleslist);
        // $newSalesDay = new DateTime($newSalesDay);
        return $saleslist;
    }
}