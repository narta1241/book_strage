<?php

namespace App\Http\Controllers;

use App\BookSearch;
use Illuminate\Http\Request;


class BookSearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     //google books api のindex
    // public function index(Request $request)
    // {
    //     // dd($request);
    //     $request['title'] = $request['title'] . ' 1';
    //     // dd($request['title']);
    //     $serieslist = BookSearch::titlesearch( $request['title'] );
    //     // dd($serieslist);
    //     //画像がないものはバリデ
    //     return view('bookSearch.index', compact('serieslist'));
    // }
    public function index(Request $request)
    {
        // dump($request);
        $keyword = $request->keyword;
        if(!$keyword){
            return redirect()->route('series.index');
        }
        //  $request['keyword'] = $request['keyword'] . ' 1';
        $serieslist = BookSearch::titleSearch($keyword);
        
        // dd($keyword);
        return view('bookSearch.index', compact('serieslist', 'keyword'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BookSearch  $bookSearch
     * @return \Illuminate\Http\Response
     */
    public function show(BookSearch $bookSearch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BookSearch  $bookSearch
     * @return \Illuminate\Http\Response
     */
    public function edit(BookSearch $bookSearch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BookSearch  $bookSearch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BookSearch $bookSearch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BookSearch  $bookSearch
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookSearch $bookSearch)
    {
        //
    }
     public function search(Request $request)
    {
        // dd($request);
        return redirect()->route('bookSearch.index',$request->keyword);
    }
}
