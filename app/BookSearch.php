<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use RakutenRws_Client;

class BookSearch extends Model
{
    public static function titleSearch($keyword)
    {
        //楽天APIを扱うRakutenRws_Clientクラスのインスタンスを作成します
        $client = new RakutenRws_Client();

        // アプリIDをセット！
        $client->setApplicationId(config('app.rakuten_id'));

        // リクエストから検索キーワードを取り出し

        // IchibaItemSearch API から、指定条件で検索
        if (!empty($keyword)) {
            $response = $client->execute('BooksBookSearch', array(
                // 入力パラメーター
                'title' => $keyword,
            // 'keyword' => $keyword,
            ));
        }
        // レスポンスが正しいかを isOk() で確認することができます
        $seriesList = [];
        if ($response->isOk()) {
            $seriesList = array();
            // 配列で結果をぶち込んで行きます
            foreach ($response as $item) {
                // 画像サイズを変えたかったのでURLを整形します
                // $str = str_replace("_ex=128x128", "_ex=175x175", $item['mediumImageUrls'][0]['imageUrl']);
                $seriesList[] = array(
                    'isbn' => $item['isbn'],
                    'title' => $item['title'],
                    'author' => $item['author'],
                    'publisher' => $item['publisherName'],
                    'largeImageUrls' => $item['largeImageUrl'],
                );
            }
        } else {
            // throw new \Exception($response->getMessage());
            \Log::error($response->getMessage());
        }
        return $seriesList;
    }

    public static function bookSearch($keyword)
    {
        //楽天APIを扱うRakutenRws_Clientクラスのインスタンスを作成します
        $client = new RakutenRws_Client();

        //アプリIDをセット！
        $client->setApplicationId(config('app.rakuten_id'));

        //リクエストから検索キーワードを取り出し

        // IchibaItemSearch API から、指定条件で検索

        if (!empty($keyword)) {
            $response = $client->execute('BooksBookSearch', array(
                'isbn' => $keyword,
            ));
        }
        // レスポンスが正しいかを isOk() で確認することができます
        if ($response->isOk()) {
            $seriesList = array();
            // 配列で結果をぶち込んで行きます
            foreach ($response as $item) {
                //画像サイズを変えたかったのでURLを整形します
                // $str = str_replace("_ex=128x128", "_ex=175x175", $item['mediumImageUrls'][0]['imageUrl']);
                $seriesList[] = array(
                    'isbn' => $item['isbn'],
                    'title' => $item['title'],
                    'author' => $item['author'],
                    'publisher' => $item['publisherName'],
                    'largeImageUrls' => $item['largeImageUrl'],
                );
            }
        } else {
            echo 'Error:' . $response->getMessage();
        }
        return $seriesList[0];
    }

    public static function saleDaySearch($keyword)
    {
        $client = new RakutenRws_Client();
        $saleslist = "";

        //アプリIDをセット！
        $client->setApplicationId(config('app.rakuten_id'));

        //リクエストから検索キーワードを取り出し

        // IchibaItemSearch API から、指定条件で検索
        if (!empty($keyword)) {
            $response = $client->execute('BooksBookSearch', array(
            //入力パラメーター
                'title' => $keyword,
                'sort' => '-releaseDate',
                'hits' => '1',
            // 'keyword' => $keyword,
            ));
        //エラー回避
        // sleep(1);
        }
        // レスポンスが正しいかを isOk() で確認することができます
        if ($response->isOk()) {
            foreach ($response as $item) {
                $saleslist = $item['salesDate'];
            }
        } else {
            echo 'Error:' . $response->getMessage();
        }

        return $saleslist;
    }
}
