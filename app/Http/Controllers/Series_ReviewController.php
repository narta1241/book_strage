<?php

namespace App\Http\Controllers;

use App\Series_Review;
use App\Series;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Series_ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reviews = Series_Review::all();
    //   dd($reviews);
        return view('/series/series_reviews.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function create(Request $request)
    {
        // dump($request);
        $title = Series::where('id',$request->series)->value('title');
        $id = $request->series;
        // dd($id);
        return view('/series/series_reviews.create',compact('title', 'id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Series_Review::create([
            'user_id' => $request->input('user_id'),
            'series_id' => $request->input('series_id'),
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
    public function edit($id)
    {
        $book = Series_Review::where('series_id',$id)->where('user_id',Auth::id())->first();
        // dd($book);
        return view('/series/series_reviews.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $review = Series_Review::where('series_id',$request->input('series_id'))->where('user_id',Auth::id())->first();
        // dd($review);
        
        $review->user_id = $request->input('user_id');
        $review->series_id = $request->input('series_id');
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
    public function destroy($id)
    {
        $result = Series_Review::where('series_id', $id)->where('user_id',Auth::id())->first();
        $result->delete();
        
        return redirect()->route('series.index');
    }
}
