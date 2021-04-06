<?php

namespace App\Http\Controllers;

use App\FavoriteSeries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteSeriesController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dump($request);
        // お気に入りを取得する
        $favorite = FavoriteSeries::where('user_id', Auth::id())
            ->where('series_id', $request->input('series_id'))
            ->first();
            // dd($favorite);
        // 既にお気に入りされている場合
        if ($favorite)  {
            $favorite->delete();

            return response()->json([
                'result' => 'deleted'
            ]);
        // お気に入りされていない場合

        } else {

            FavoriteSeries::create([
                'series_id' => $request->input('series_id'),
                'user_id' => Auth::id(),
            ]);

             return response()->json([
                'result' => 'created'
            ]);
        }
        // return redirect()->route('series.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FavoriteSeries  $favorite_Series
     * @return \Illuminate\Http\Response
     */
    public function show(FavoriteSeries $favorite_Series)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FavoriteSeries  $favorite_Series
     * @return \Illuminate\Http\Response
     */
    public function edit(FavoriteSeries $favorite_Series)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FavoriteSeries  $favorite_Series
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FavoriteSeries $favorite_Series)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FavoriteSeries  $favorite_Series
     * @return \Illuminate\Http\Response
     */
    public function destroy(FavoriteSeries $favorite_Series)
    {
        //
    }
}
