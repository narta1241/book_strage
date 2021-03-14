<?php

namespace App\Http\Controllers;

use App\Favorite_Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteBookController extends Controller
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
        $favorite = Favorite_Book::where('user_id', Auth::id())
            ->where('book_id', $request->input('book_id'))
            ->first();
            
        // 既にいいねされている場合
        if ($favorite)  {
            $favorite->delete();
         
        // いいねされていない場合
            
        } else {
            
            Favorite_Book::create([
                'book_id' => $request->input('book_id'),
                'user_id' => Auth::id(),
            ]);
        }
        
        return redirect()->route('books.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Favorite_Book  $favorite_Book
     * @return \Illuminate\Http\Response
     */
    public function show(Favorite_Book $favorite_Book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Favorite_Book  $favorite_Book
     * @return \Illuminate\Http\Response
     */
    public function edit(Favorite_Book $favorite_Book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Favorite_Book  $favorite_Book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Favorite_Book $favorite_Book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Favorite_Book  $favorite_Book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Favorite_Book $favorite_Book)
    {
        //
    }
}
