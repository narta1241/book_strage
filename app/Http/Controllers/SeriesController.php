<?php

namespace App\Http\Controllers;

use App\Series;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SeriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $serieslist =Series::all();
        $user = User::where('id', Auth::id())->first();
        // dd($user);
        return view('series.index', compact('serieslist', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('series.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $request->validate([       // <-- ここがバリデーション部分
            'title' => 'required',
            'current_volume' => 'required',
        ]);
        Series::create([
            'user_id' => Auth::id(),
            'title' => $request->input('title'),
            'author' => $request->input('author'),
            'publisher' => $request->input('publisher'),
            'current_volume' => $request->input('current_volume'),
            'final_flg' => $request->input('final_flg')
        ]);

        return redirect()->route('series.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Series  $series
     * @return \Illuminate\Http\Response
     */
    public function show(Series $series)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Series  $series
     * @return \Illuminate\Http\Response
     */
    public function edit(Series $series)
    {
        return view('series.edit', compact('series'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Series  $series
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Series $series)
    {
        $validator = $request->validate([       // <-- ここがバリデーション部分
            'title' => 'required',
            'current_volume' => 'required',
        ]);
        $series->title = $request->input('title');
        $series->author = $request->input('author');
        $series->publisher = $request->input('publisher');
        $series->current_volume = $request->input('current_volume');
        $series->final_flg = $request->input('final_flg');
        $series->save();

        return redirect()->route('series.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Series  $series
     * @return \Illuminate\Http\Response
     */
    public function destroy(Series $series)
    {
        $series->delete();

        return redirect()->route('series.index');
    }
}
