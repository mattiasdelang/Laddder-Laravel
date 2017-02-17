<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Requests;
use DB;
use App\Activity;


class AchievementsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $userId = \Auth::id();
        $activities = Activity::where('userId', $userId)->orderBy('created_at', 'desc')->take(5)->get();
        $newactivity = Activity::where('userId', $userId)->where('seen', 0)->orderBy('created_at', 'desc')->get();
        if (count($newactivity) > 0) {
            view()->share('newactivity', 'newact');
        }
        else
        {
            view()->share('newactivity', '');
        }
        view()->share('activities', $activities);
    }

    public function showAchievements(){

        if (!Auth::check()) {
            return redirect('/')->withErrors(["You're not logged in."]);
        }

        $user = \Auth::user();
        $ranks = DB::table('user_ranks')
            ->orderBy('id', 'desc')
            ->get();

        return view('users.achievements',compact('user', 'ranks'));

    }
}
