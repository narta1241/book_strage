<?php

namespace App\Http\Controllers;

use App\User;
use App\Series;
use App\UserSeries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\CalendarView;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::where('id', Auth::id())->first();
        $Owned_book = UserSeries::where('user_id', $user->id)->pluck('series_id');

        $serieslist = Series::whereIn('id', $Owned_book)->orderBy('created_at', 'desc')->paginate(10);
        // 次巻発売日を検索
        User::getSalesDate();

        $m = isset($_GET['m']) ? htmlspecialchars($_GET['m'], ENT_QUOTES, 'utf-8') : '';
        $y = isset($_GET['y']) ? htmlspecialchars($_GET['y'], ENT_QUOTES, 'utf-8') : '';

        if ($m != '' || $y != '') {
            $dt = Carbon::createFromDate($y, $m, 01);
        } else {
            $dt = Carbon::createFromDate();
        }

        $dt = CalendarView::renderCalendar($dt);
        return view('user.index', compact('serieslist', 'user', 'dt'));
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
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }
}
