<?php

namespace App\Http\Controllers;

use Auth;

use App\Activity;
use App\UserExperience;
use App\Http\Requests\SearchRequest;
use App\User;
use App\UserReferfriend;
use Input;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use DB;
use Carbon;
use DateTime;
use DateInterval;
class SearchController extends Controller
{
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

	public function view (){
		return view('searchUsers');
	}
	public function log2(){
		console.log('log2');
	}
	public function search(SearchRequest $request){
		 $query = $request->get("search");
		
		 	$usersearch = DB::table('users')->where('username', 'LIKE', '%' . $query . '%')->get();


		 	$tagsearch = DB::table('project_images')->where('tags', 'LIKE', '%' . $query . '%')
		 	->join('users', 'users.userId', '=', 'project_images.userId')
		 	->select('project_images.*', 'users.userId','users.username')
		 	->get();



		 	$projectsearch = DB::table('project_images')
		 	->where('title', 'LIKE', '%' . $query . '%')
		 	->join('users', 'users.userId', '=', 'project_images.userId')
		 	->select('project_images.*', 'users.userId','users.username')
		 	->get();

		    return view('searchUsers', compact('usersearch', 'query', 'projectsearch', 'tagsearch'));
		 
		
		 


 	}
	


}

