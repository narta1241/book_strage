<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\GenerateTextFile;
use App\Http\Components\FileOperation;

class SampleController extends Controller
{
    const MAX = 3000; // ループ回数

    private $fp;

    public function __construct()
    {
        $this->fp = new FileOperation();
    }

    // public function queuesNone()
    // {
    //     $start = time();

    //     $file = $this->fp->makeTextFile();

    //     $this->fp->write($file, self::MAX);

    //     return view('sample_queues', ['start' => $start]);
    // }

    // public function queuesDatabase()
    // {
    //     $start = time();

    //     $file = $this->fp->makeTextFile();

    //     GenerateTextFile::dispatch($file, self::MAX);

    //     return view('sample_queues', ['start' => $start]);
    // }
    
    public function queuesSalesDate()
    {
        // $day = $this->fp->getSalesDate();
        // $file = $this->fp->makeTextFile();
        GenerateTextFile::dispatch();
        // echo ('非同期処理実行後のテキスト');
        // dd($a);
        return '送信完了';
    }
}
