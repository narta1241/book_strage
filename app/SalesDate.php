<?php
        $Owned_book = UserSeries::where('user_id', Auth::id())->pluck('series_id');
        dd($Owned_book);
        $seriesList = Series::whereIn('id', $Owned_book)->where('final_flg', 0)->orderBy('created_at','desc')->get();
        // dump($seriesList);
        $today = date('Y/m/d');
        $today = new DateTime($today);
        // dump($today);
        foreach($seriesList as $series){
            $salesDay = preg_replace('/[^0-9]/', '', $series->salesDate);
            // dump($salesDay);
            if($salesDay){
                $salesDay =new Datetime($salesDay);
            }
            if(!$salesDay || $salesDay < $today){

                // dump($salesDay);
                $series->salesDate = BookSearch::saleDaySearch($series->title);
                // dd($series->salesDate);
                $newSalesDay = preg_replace('/[^0-9]/', '', $series->salesDate);
                $newSalesDay = new Datetime($newSalesDay);
            // dump($salesDay);
                if($newSalesDay>$today){
                    // dd($newSalesDay);
                    $series->save();
                }
            }

        }
        return redirect()->route('user.index');
?>
