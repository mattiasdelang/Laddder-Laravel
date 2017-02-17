<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Requests;
use App\Project;
use App\User;
use Input;
use App\ProjectComment;
use App\UserApikey;
use App\Activity;

class ApiController extends Controller
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

    public function popular($apikey){

        $keystatus = UserApikey::checkKey($apikey);

        if($keystatus == 'true')
        {
            if(Input::has('page'))
                $page = Input::get('page');

            if(Input::has('perpage'))
                $perpage = Input::get('perpage');

            $projectinfo = Project::orderBy('likeCount', 'desc')->get();
            $list = array();

            foreach ($projectinfo as $pinfo) {
                $userinfo = User::where('userId', $pinfo->userId)->select('username', 'image')->get();
                $comments = ProjectComment::where('projectId', $pinfo->projectId)->select('comment')->get();
                $comment = array();
                foreach ($comments as $c) 
                    {
                        $eachcomment = $c->comment;
                        array_push($comment, $eachcomment);
                    }

                $projects = array(
                    'title' => $pinfo->title, 
                    'url' => url() . '/projects/' . $pinfo->projectId, 
                    'image_url' => url() . '/project_images/' . $pinfo->image,
                    'author_name' => $userinfo[0]->username,
                    'author_profile_image' => url() . '/profilepics/' . $userinfo[0]->image,
                    'comments' => $comment,
                    'likes' => $pinfo->likeCount,
                    'id' => $pinfo->projectId
                    );
                array_push($list, $projects);
            } 

            if (isset($page) && isset($perpage)) {
                $list = array_slice($list, ($page - 1) * $perpage, $perpage);
            }

            return \Response::json($list, $status=200, $headers=[], $options=JSON_PRETTY_PRINT);
        }
        else
        {
            return redirect('/homepage')->withErrors(["Your API key isn't correct. You can find yours at " . url() . "/apikey."]);
        }
        
    }

    public function project($id, $apikey){

        $keystatus = UserApikey::checkKey($apikey);

        if($keystatus == 'true')
        {
            $list = array();

            $projectinfo = Project::where('projectId', $id)->select('title', 'image', 'userId', 'likeCount')->get();
            $userinfo = User::where('userId', $projectinfo[0]->userId)->select('username', 'image')->get();
            $comments = ProjectComment::where('projectId', $id)->select('comment')->get();
            $comment = array();
            foreach ($comments as $c)
            {
                $eachcomment = $c->comment;
                array_push($comment, $eachcomment);
            }

            $project = array(
                'title' => $projectinfo[0]->title,
                'url' => url() . '/projects/' . $id,
                'image_url' => url() . '/project_images/' . $projectinfo[0]->image,
                'author_name' => $userinfo[0]->username,
                'author_profile_image' => url() . '/profilepics/' . $userinfo[0]->image,
                'comments' => $comment,
                'likes' => $projectinfo[0]->likeCount,
                'id' => $id
            );

            array_push($list, $project);

            return \Response::json($list, $status=200, $headers=[], $options=JSON_PRETTY_PRINT);
        }
        else
        {
            return redirect('/homepage')->withErrors(["Your API key isn't correct. You can find yours at " . url() . "/apikey."]);
        }

    }

}
