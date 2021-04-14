<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\GenerateTextFile;
use App\Http\Components\FileOperation;
use App\Series;
use App\UserSeries;
use Illuminate\Support\Facades\Auth;
use DateTime;

class SampleController extends Controller
{
    const MAX = 3000; // ループ回数

    private $fp;

    public function __construct()
    {
        $this->fp = new FileOperation();
    }
    // public function queuesDatabase()
    // {
    //     $start = time();

    //     $file = $this->fp->makeTextFile();

    //     GenerateTextFile::dispatch($file, self::MAX);

    //     return view('sample_queues', ['start' => $start]);
    // }
    
    public function queuesBookSearch()
    {
        $Owned_book = UserSeries::where('user_id', Auth::id())->pluck('series_id');
        // dump($Owned_book);
        $serieslist = Series::whereIn('id', $Owned_book)->where('final_flg', 0)->orderBy('created_at','desc')->get();
        // dd($serieslist);
        $today = date('Y/m/d');
        // dump($today);
        $today = new DateTime($today);
        // dd($series);
        
        $file = $this->fp->makeTextFile();
        GenerateTextFile::dispatch($file,$serieslist,$today);

        // dd($ans);//ここでddをすると日付の情報がない
        // return $ans;
    }
}
