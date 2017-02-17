<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Activity;
use App\Http\Requests;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function __construct()
    {
        $userId = Auth::id();
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

    public function getIndex()
    {
        $followers = Auth::user()->followers();
        $following = Auth::user()->following();
        return view('followers.index')
            ->with('followers', $followers)
            ->with('following', $following);
    }

    public function getFollow($username)
    {
        $user = User::where('username', $username)->first();
        if (!$user) {
            return redirect('/homepage');
        }

        if(Auth::user()->isFollowing($user)) {
            return redirect()->back();
        }

        Auth::user()->follow($user);
        return redirect()->back();
    }
}
