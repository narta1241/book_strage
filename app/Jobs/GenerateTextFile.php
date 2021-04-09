<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Components\FileOperation;

class GenerateTextFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $file;
    private $fp;
    private $max;

    // public function __construct($file, $max)
    // {
    //     $this->file = $file;
    //     $this->max  = $max;
    //     $this->fp   = new FileOperation();
    // }
      public function __construct()
    {
        // $this->day = $day;
        $this->fp = new FileOperation();
    }

    public function handle()
    {
        // 書き込み
        $this->fp->getSalesDate();
        // $this->fp->write($this->file, $this->max);
        // return "非同期処理実行";
    }
}