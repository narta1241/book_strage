<?php

namespace App\Http\Controllers;

use App\Favorite_Series;
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
        // dd($request);
        // いいねを取得する
        $favorite = Favorite_Series::where('user_id', Auth::id())
            ->where('series_id', $request->input('series_id'))
            ->first();
            // dd($favorite);
        // 既にいいねされている場合
        if ($favorite)  {
            $favorite->delete();
         
        // いいねされていない場合
            
        } else {
            
            Favorite_Series::create([
                'series_id' => $request->input('series_id'),
                'user_id' => Auth::id(),
            ]);
        }
        return redirect()->route('series.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Favorite_Series  $favorite_Series
     * @return \Illuminate\Http\Response
     */
    public function show(Favorite_Series $favorite_Series)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Favorite_Series  $favorite_Series
     * @return \Illuminate\Http\Response
     */
    public function edit(Favorite_Series $favorite_Series)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Favorite_Series  $favorite_Series
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Favorite_Series $favorite_Series)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Favorite_Series  $favorite_Series
     * @return \Illuminate\Http\Response
     */
    public function destroy(Favorite_Series $favorite_Series)
    {
        //
    }
}
