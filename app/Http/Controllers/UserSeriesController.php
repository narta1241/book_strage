<?php

namespace App\Http\Controllers;

use App\Series;
use App\UserSeries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserSeriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Series $series)
    {
        return view('users_series.create', compact('series'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Series $series, Request $request)
    {
        $maxV = Series::where('id', $series->id)->value('current_volume');
        $request->validate([
            'volume' => "required|numeric|max:$maxV",
        ]);

        UserSeries::create([
            'user_id' => Auth::id(),
            'series_id' => $series->id,
            'volume' => $request->input('volume'),
        ]);

        return redirect()->route('series.index');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\UserSeries  $userSeries
     * @return \Illuminate\Http\Response
     */
    public function show(UserSeries $userSeries)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserSeries  $userSeries
     * @return \Illuminate\Http\Response
     */
    public function edit(Series $series)
    {
        $volume = UserSeries::where('series_id', $series->id)->where('user_id', Auth::id())->value('volume');
        if (!$volume) {
            session()->flash('flash_message', '登録ユーザーではないので編集できません。');
            return redirect()->route('series.index');
        }

        return view('users_series.edit', compact('series', 'volume'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserSeries  $userSeries
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $series)
    {

        $maxV = Series::where('id', $series)->value('current_volume');

        $request->validate([
            'volume' => "required|numeric|max:$maxV",
        ]);
        $userSeries = UserSeries::where('series_id', $series)->where('user_id', Auth::id())->first();

        $userSeries->volume = $request->input('volume');
        $userSeries->save();

        return redirect()->route('series.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserSeries  $userSeries
     * @return \Illuminate\Http\Response
     */
    public function destroy($userSeries)
    {
        $result = UserSeries::where('series_id', $userSeries)->where('user_id', Auth::id())->first();
        $result->delete();
        return redirect()->route('series.index');
    }
}
