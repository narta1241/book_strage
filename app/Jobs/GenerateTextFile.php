<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Components\FileOperation;
use App\UserSeries;
use App\Series;
use DateTime;
use App\BookSearch;
use RakutenRws_Client;
use Illuminate\Support\Facades\Auth;


class GenerateTextFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $file;
    private $series;
    private $serieslist;
    private $Owned_book;
    private $fp;
    private $today;

    public function __construct($file,$serieslist,$today)
    {
        $this->file = $file;
        // $this->max  = $max;
        $this->series  = $serieslist;
        $this->today = $today;
        $this->fp   = new FileOperation();
        // $Owned_book = UserSeries::where('user_id', Auth::id())->pluck('series_id');
        // $serieslist = Series::whereIn('id', $Owned_book)->where('final_flg', 0)->orderBy('created_at','desc')->get();
    }
    //   public function __construct($title)
    // {
    //     $this->title = $title;
    //     $this->max = 5;
    //     $this->fp = new FileOperation();
    // }

   
    public function handle()
    {
        foreach($this->series as $series)
        {
                $salesDay = preg_replace('/[^0-9]/', '', $series->salesDate);
            if($series->salesDate){
                $salesDay = $this->fp->changeDay($salesDay); 
            }
            if(!$salesDay || $salesDay < $this->today){
                $data = $this->fp->getBookSearch($series->title,$series->author);
                $newSalesDay = preg_replace('/[^0-9]/', '', $data);
                //エラー回避
                sleep(1);
                
                $this->fp->write($this->file, $newSalesDay);
                
                $newSalesDay = $this->fp->changeDay($newSalesDay);
          
                if($newSalesDay>$this->today){
                    $this->fp->save($data, $series->id);
                }
            }
            
        }
    }
}