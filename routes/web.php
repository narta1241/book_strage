<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::resource('series', 'SeriesController');
Route::resource('books', 'BookController')->middleware('auth');
Route::get("series_reviews/{series}", 'Series_ReviewController@create')->name('series_reviews.create');
Route::resource('series_reviews', 'Series_ReviewController')->middleware('auth');
Route::resource('favorite_series', 'FavoriteSeriesController')->middleware('auth');
Route::resource('favorite_books', 'FavoriteBookController')->middleware('auth');

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
