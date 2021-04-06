<?php

namespace App\Http\Controllers;

use App\SeriesReview;
use App\Series;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeriesReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Series $series)
    {
        // dump($series);
        $reviews = SeriesReview::where('series_id', $series->id)->get();
        $series = Series::where('id', $series->id)->first();
        // dd($reviews);
        return view('/series/series_reviews.index', compact('reviews','series'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(Series $series)
    {
        // dump($request);
        $title = $series->title;
        $id = $series->id;
        // dump($id);
        // $result = SeriesReview::where('series_id', $id)->where('user_id', Auth::id())->first();
        // $validator = $request->validate([
        //     'series_id' => "exists:$result",
        // ]);
        // dd($validator);
        return view('/series/series_reviews.create', compact('title', 'id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Series  $series
     * @return \Illuminate\Http\Response
     */
    public function store(Series $series, Request $request)
    {
        $validator = $request->validate([
            'comment' => 'required',
            'star' => 'required',
        ]);
        SeriesReview::create([
            'user_id' => Auth::id(),
            'series_id' => $series->id,
            'comment' => $request->input('comment'),
            'star' => $request->input('star')
        ]);

        return redirect()->route('series.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($series)
    {
        // dump($id);
        $book = SeriesReview::where('series_id', $series)->where('user_id', Auth::id())->first();
        if (!$book) {
            session()->flash('flash_message', '登録ユーザーではないので編集できません。');
            return redirect()->route('series.series_reviews.index', ['series' => $series]);
        }


        return view('/series/series_reviews.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($series, Request $request)
    {
        $validator = $request->validate([
            'comment' => 'required',
            'star' => 'required',
        ]);
        $review = SeriesReview::where('series_id', $series)->where('user_id', Auth::id())->first();
        // dd($review);

        $review->comment = $request->input('comment');
        $review->star = $request->input('star');
        $review->save();

        return redirect()->route('series_reviews.index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($series)
    {
        $result = SeriesReview::where('series_id', $series)->where('user_id',Auth::id())->first();
        $result->delete();

        return redirect()->route('series.index');
    }
}
