<?php

namespace App\Http\Controllers;

use App\Series;
use App\BookSearch;
use Illuminate\Http\Request;

class BookSearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        if (!empty($keyword)) {
            $seriesList = BookSearch::titleSearch($keyword);
        } else {
            $seriesList = Series::orderBy('created_at','desc')->paginate(10);
        }
        return view('bookSearch.index', compact('seriesList', 'keyword'));
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

    /**
     *
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $request->validate([
            'keyword' => 'required',
        ]);
        return redirect()->route('bookSearch.index', $request->keyword);
    }
}
