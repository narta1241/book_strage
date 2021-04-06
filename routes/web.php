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
// Route::resource('series.series_reviews', 'SeriesReviewController')->middleware('auth');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('series.user_series', 'UserSeriesController');
    // Route::get('series/{series}/user_series', 'UserSeriesController@index')->name('series.user_series.index')->middleware('auth');
    // Route::get('series/{series}/user_series/create', 'UserSeriesController@create')->name('series.user_series.create')->middleware('auth');
    // Route::post('series/{series}/user_series/store', 'UserSeriesController@store')->name('series.user_series.store')->middleware('auth');
    // Route::get('series/{series}/user_series/edit', 'UserSeriesController@edit')->name('series.user_series.edit')->middleware('auth');
    // Route::put('series/{series}/user_series/update', 'UserSeriesController@update')->name('series.user_series.update')->middleware('auth');
    // Route::delete('series/{series}/user_series/destroy', 'UserSeriesController@destroy')->name('series.user_series.destroy')->middleware('auth');

    Route::resource('series.series_reviews', 'SeriesReviewController');
    // Route::get('series/{series}/series_reviews', 'SeriesReviewController@index')->name('series.series_reviews.index')->middleware('auth');
    // Route::get('series/{series}/series_reviews/create', 'SeriesReviewController@create')->name('series.series_reviews.create')->middleware('auth');
    // Route::post('series/{series}/series_reviews/store', 'SeriesReviewController@store')->name('series.series_reviews.store')->middleware('auth');
    // Route::get('series/{series}/series_reviews/edit', 'SeriesReviewController@edit')->name('series.series_reviews.edit')->middleware('auth');
    // Route::put('series/{series}/series_reviews/update', 'SeriesReviewController@update')->name('series.series_reviews.update')->middleware('auth');
    // Route::delete('series/{series}/series_reviews/destroy', 'SeriesReviewController@destroy')->name('series.series_reviews.destroy')->middleware('auth');

    Route::resource('favorite_series', 'FavoriteSeriesController');
});

Route::resource('series', 'SeriesController');
// Route::resource('user_series', 'UserSeriesController')->middleware('auth');
// Route::get('series/{series}/favorite_series/store', 'FavoriteSeriesController@store')->name('series.favorite_series.store')->middleware('auth');


// TODO: SeriesController@indexと全く同じ処理なのでそこにルーティングするようにしましょう
Route::get('/', 'SeriesController@index');
// Route::get('/', function () {
//     $serieslist = App\Series::all();
//     $user = App\User::where('id', Auth::id())->first();
//     return view('series.index', compact('serieslist', 'user'));
// });

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
