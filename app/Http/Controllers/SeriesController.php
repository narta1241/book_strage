<?php

namespace App\Http\Controllers;

use App\Series;
use App\User;
use App\BookSearch;
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
        $user = User::where('id', Auth::id())->first();

        if (!empty($_GET['search'])) {
            $seriesList = Series::where('title', 'like', "%{$_GET['search']}%")->orderBy('created_at', 'desc')->paginate(10);
        } else {
            $seriesList = Series::orderBy('created_at', 'desc')->paginate(10);
        }
        return view('series.index', compact('seriesList', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $series = BookSearch::bookSearch($id);
        return view('series.create', compact('series'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //タイトルの中にある巻数の削除
        $title = $request->input('title');
        $cut = 0;
        if (strpos($title, '（')) {
            $cut = mb_strlen($title) - mb_strpos($title, '（');
        } else {
            $cut = 0;
        }

        $title = mb_substr($title, 0, mb_strlen($title) - $cut);

        $request->validate([       // <-- ここがバリデーション部分
            'title' => "required|unique:series,title",
            'current_volume' => 'required',
        ]);

        Series::create([
            'user_id' => Auth::id(),
            'title' => $title,
            'author' => $request->input('author'),
            'publisher' => $request->input('publisher'),
            'image' => $request->input('image'),
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
    public function show(Request $request)
    {
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
        $request->validate([       // <-- ここがバリデーション部分
            'title' => 'required',
            'current_volume' => 'required',
        ]);

        $series->title = $request->input('title');
        $series->author = $request->input('author');
        $series->publisher = $request->input('publisher');
        $series->image = $request->input('image');
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
