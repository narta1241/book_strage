<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;      //CarbonはLaravelで日付を扱う時に利用可能な便利なライブラリ
use App\Series;
use Datetime;
use App\User;

class CalendarView extends Model
{
    private $carbon;
          
    public static function renderCalendar($dt)
    {
        $dt->startOfMonth(); //今月の最初の日
        $dt->timezone = 'Asia/Tokyo'; //日本時刻で表示
        $style = "";//CSS 色
        $styleBG = "";//CSS　背景色
        // $display ="";//js 発売日表示
        
        $salesDays = Series::wherenotNull('salesDate')->pluck('salesDate');
        $regularDays = [];
        // dd($salesDays);
        foreach ($salesDays as $salesDay) {
            $salesDay = preg_replace('/[^0-9]/', '', $salesDay);
            // dump($salesDay);
            $salesDay = new Datetime($salesDay);
            $regularDays[] = $salesDay->format('Y-m-d');
        }
        // dd($salesDays);
        // dd($regularDays[0]->format('Y'));
         //１ヶ月前
        $sub = Carbon::createFromDate($dt->year, $dt->month, $dt->day);
        $subMonth = $sub->subMonth();
        $subY = $subMonth->year;
        $subM = $subMonth->month;
        
        //1ヶ月後
        $add = Carbon::createFromDate($dt->year, $dt->month, $dt->day);
        $addMonth = $add->addMonth();
        $addY = $addMonth->year;
        $addM = $addMonth->month;
        
        //今月
        $today = Carbon::createFromDate();
        $todayY = $today->year;
        $todayM = $today->month;

        // dump($sub);
        // dump($add);
        
       //リンク
        $title = '<caption><a href="./user?y=' . $todayY . '&&m=' . $todayM . '">今日　</a>';
        $title .= '<a href="./user?y=' . $subY . '&&m=' . $subM . '"><<前月 </a>';//前月のリンク
        $title .= $dt->year . '年' . $dt->month . '月';//月と年を表示
        $title .= '<a href="./user?y=' . $addY . '&&m=' . $addM . '"> 来月>></a></caption>';//来月リンク
        // $title .= '<button type="button" class="ml-4" id="btn" onclick="getSalesDate()">発売情報更新</button></div>';
        // //曜日の配列作成
        $headings = ['月','火','水','木','金','土','日'];
        
        $calendar = '<div class="calendar"><table class="table" border=1>';
        $calendar .= '<thead>';
        
        foreach ($headings as $heading) {
            $calendar .= '<th class="text-center header">' . $heading . '</th>';
        }
        $calendar .= '</thead>';
        
        $calendar .= "<tbody><tr>";
        
       //今月は何日まであるか
        $daysInMonth = $dt->daysInMonth;
       
        for ($i = 1; $i <= $daysInMonth; $i++) {
            if ($i == 1) {
                if ($dt->format('N') != 1) {
                    $calendar .= '<td colspan="' . ($dt->format('N') - 1) . '"></td>'; //1日が月曜じゃない場合はcolspanでその分あける
                }
            }
            
            if ($dt->format('N') == 1) {
                $calendar .= '</tr><tr>'; //月曜日だったら改行
            }
            if ($dt->format('N') == 6) {
                $style = "#03C"; //土曜日だったら青
            }
            if ($dt->format('N') == 7) {
                $style = "#C30"; //日曜日だったら青
            }
            $today = date('Y-m-d');
            if ($dt->format('Y-m-d') == $today) {
                $styleBG = 'silver';
            }
            // dump($dt);
            // dump($dt->format('Y-m-d'));
            // dd($regularDays);
            if (in_array($dt->format('Y-m-d'), $regularDays)) {
                $styleBG = "#0f3";//発売日だったら背景色を黄緑
            }
                $calendar .= "<td class='day' style =\"color:" . $style . "; background-color:" . $styleBG . " ;\">" . $dt->day . '</td>';
             
            $dt->addDay();
            $style = "";
            $styleBG = "";
         //   $display ="";
        }

        $calendar .= '</tr></tbody>';
        $calendar .= '</table></div>';
        return $title . $calendar;
    }
    public static function getSalesDate()
    {
        $Owned_book = UserSeries::where('user_id', Auth::id())->pluck('series_id');
        dd($Owned_book);
        $serieslist = Series::whereIn('id', $Owned_book)->where('final_flg', 0)->orderBy('created_at', 'desc')->get();
        // dump($serieslist);
        $today = date('Y/m/d');
        $today = new DateTime($today);
        // dump($today);
        foreach ($serieslist as $series) {
            $salesDay = preg_replace('/[^0-9]/', '', $series->salesDate);
            // dump($salesDay);
            if ($salesDay) {
                $salesDay = new Datetime($salesDay);
            }
            if (!$salesDay || $salesDay < $today) {
                // dump($salesDay);
                $series->salesDate = BookSearch::saleDaySearch($series->title);
                // dd($series->salesDate);
                $newSalesDay = preg_replace('/[^0-9]/', '', $series->salesDate);
                $newSalesDay = new Datetime($newSalesDay);
            // dump($salesDay);
                if ($newSalesDay > $today) {
                    // dd($newSalesDay);
                    $series->save();
                }
            }
        }
    }
}
