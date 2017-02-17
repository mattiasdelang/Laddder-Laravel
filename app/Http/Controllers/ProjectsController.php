<?php

namespace App\Http\Controllers;

use App\Activity;
use App\UserExperience;
use App\Project;
use App\ProjectLike;
use App\ProjectComment;
use App\ProjectFlag;
use Input;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\ProjectRequest;
use DB;
use DateTime;



class ProjectsController extends Controller
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
    
    public function index()
    {
        return ("There's no view for this yet");
    }

///////////////////////////////////////////////////////////

    public function create()
    {
        if (!Auth::check()) {
            return redirect('/login')->withErrors(['You are not logged in.']);
        }

        return view("projects.create");
    }

///////////////////////////////////////////////////////////

    public function store(StoreProjectRequest $request)
    {      
        $pUserId = Auth::user()->userId;
        
        $messages = [
            'pName.required' => "Don't forget to give your project a name." ,
            'pName.max' => "Please give your project a shorter name. Like, 'Bob'." ,
            'image_file.required' => "Please select an image for your project." ,
            'pDescription.required' => "Please describe this project." ,
        ];
        
        $this->validate($request, [
            
            'pName' => 'required|max:255',
            'image_file' => 'required',
            'pDescription' => 'required',
        ], $messages);
        


        //desired image result dimensions
        $iWidth = 400;
        $iHeight = 300;

        $iJpgQuality = 90;

        if ($_FILES) {

            //if no errors and size less than 8MB
            if (!$_FILES['image_file']['error']) {

                if (is_uploaded_file($_FILES['image_file']['tmp_name'])) {
                        
                    // new unique filename
                    $image = Input::file('image_file');
                    $ext = "" . $image->getClientOriginalExtension();

                    if($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg'|| $ext == 'PNG' || $ext == 'JPG' || $ext == 'JPEG' ){}else{return \Redirect::back()->withErrors('Please upload a JPG or PNG file. You uploaded a ' . $ext . " file.");}

                    $sLastPartFileName = md5(time() . '.' . $image->getClientOriginalExtension());

                    $sTempFileName = public_path('project_images/' . $sLastPartFileName);
                    //$sTempFileName = public_path('project_images/' . md5(time().rand()));

                    // move uploaded file into cach folder
                    move_uploaded_file($_FILES['image_file']['tmp_name'], $sTempFileName);

                    //change file permission to 644
                    @chmod($sTempFileName, 0644);


                    if (file_exists($sTempFileName) && filesize($sTempFileName) > 0) {

                        $aSize = getimagesize($sTempFileName); // try to obtain image info

                        if (!$aSize) {
                            @unlink($sTempFileName);
                            return;
                        }

                        // check for image type
                        switch ($aSize[2]) {

                            case IMAGETYPE_JPEG:
                                $sExt = '.jpg';
                                // create a new image from file
                                $vImg = @imagecreatefromjpeg($sTempFileName);
                                break;

                            case IMAGETYPE_PNG:
                                $sExt = '.png';
                                // create a new image from file
                                $vImg = @imagecreatefrompng($sTempFileName);
                                break;

                            default:
                                @unlink($sTempFileName);
                                return;
                        }

                        // create a new true color image
                        $vDstImg = @imagecreatetruecolor($iWidth, $iHeight);

                        // copy and resize part of an image with resampling

                        $wRealImg = $request->get("RealWidth");
                        $hRealImg = $request->get("RealHeight");
                        $wDispl = $request->get("DisplayWidth");
                        $hDispl = $request->get("DisplayHeight");

                        $newX1 = (int)$_POST['x1']/$wDispl*$wRealImg;
                        $newY1 = (int)$_POST['y1']/$hDispl*$hRealImg;                        
                        $newW = (int)$_POST['w']/$wDispl*$wRealImg;
                        $newH = (int)$_POST['h']/$hDispl*$hRealImg;

                        imagecopyresampled($vDstImg, $vImg, 0, 0, $newX1, $newY1, $iWidth, $iHeight, $newW, $newH);

                        // define a result image filename
                        $sResultFileName = $sTempFileName . '.jpg';
                        $sLastPartFileName = $sLastPartFileName . '.jpg';

                        // output image to file
                        imagejpeg($vDstImg, $sResultFileName, $iJpgQuality);
                        @unlink($sTempFileName);
                    }        
                }
                else
                {
                    return \Redirect::back()->withErrors('Please upload a smaller file');
                }
            }
        }


        $pName = $request->get("pName");
        $pDescription = $request->get("pDescription");
        $pImage = $sLastPartFileName;
        $pTags = $request->get("pTags");

        UserExperience::addStats($pUserId, "posts", 500);


        $url = $sResultFileName;
        $palette = new \BrianMcdo\ImagePalette\ImagePalette($url);
        $colors = $palette->colors;

        $project = new Project();
        $project->userId = $pUserId;
        $project->title = $pName;
        $project->description = $pDescription;
        $project->image = $pImage;
        $project->tags = $pTags . ', ' . $colors[0] . ', ' . $colors[1] . ', ' . $colors[2] . ', ' . $colors[3] . ', ' . $colors[4];

        $project->save();


        $id = \DB::getPdo()->lastInsertId();
        $redirecturl = '/projects/' . $id;
        return Redirect::to($redirecturl);

    }

///////////////////////////////////////////////////////////

    public function show($id)
    {
        return ("There's no view for this yet");
    }

///////////////////////////////////////////////////////////

    public function edit($id)
    {
        return ("There's no view for this yet");
    }

///////////////////////////////////////////////////////////


    public function update(Request $request, $id)
    {
        return ("There's no view for this yet");
    }

///////////////////////////////////////////////////////////

    public function destroy($id)
    {
        return ("There's no view for this yet");
    }

///////////////////////////////////////////////////////////

    public function projectDetail($id)
    {

        $project = \DB::table('project_images')->where('projectId', $id)->select('projectId', 'userId', 'title', 'description', 'image', 'tags', 'created_at')->get();
        $user = \DB::table('users')->where('userId', $project[0]->userId)->select('username', 'image', 'portfolio')->get();
        $like = \DB::table('likes')->where('userId', \Auth::id())->where('projectId', $project[0]->projectId)->select('id')->get();
        $flag = \DB::table('flags')->where('userId', \Auth::id())->where('projectId', $project[0]->projectId)->select('id')->get();
        $comment = \DB::table('comments')->where('projectId', $project[0]->projectId)->join('users', 'comments.userId', '=', 'users.userId')->select('id', 'username', 'image', 'comments.userId', 'projectId', 'comment', 'flagCount')->orderBy('comments.created_at', 'desc')->get();
        $likecount = \DB::table('likes')->where('projectId', $project[0]->projectId)->select('id')->get();
        $flagcount = \DB::table('flags')->where('projectID', $project[0]->projectId)->select('id')->get();

        $detail = [];
        $url = public_path('project_images/' . $project[0]->image);
        $palette = new \BrianMcdo\ImagePalette\ImagePalette($url);
        $colors = $palette->colors;
        $detail['colors'] = $colors;
        $detail['projectId'] = $project[0]->projectId;
        $detail['title'] = $project[0]->title;
        $detail['description'] = $project[0]->description;
        $detail['image'] = $project[0]->image;

        $search = array(', ' . $colors[0], ', ' . $colors[1], ', ' . $colors[2], ', ' . $colors[3], ', ' . $colors[4]);
        $detail['tags'] = explode(', ', str_replace($search, '', $project[0]->tags));
        $date = new DateTime($project[0]->created_at);
        $detail['created_at'] = $date->format('j F Y, h:i');;
        $detail['username'] = $user[0]->username;
        $detail['userImage'] = $user[0]->image;
        $detail['portfolio'] = $user[0]->portfolio;
        $detail['userId'] = $project[0]->userId;
        $detail['comment'] = $comment;


        if (isset($like[0])) {
            $detail['like'] = 'none';
            $detail['dislike'] = 'inline-block';
        } else {
            $detail['like'] = 'inline-block';
            $detail['dislike'] = 'none';
        }

        if (isset($likecount[0])) {
            $detail['likecount'] = count($likecount);
        } else {
            $detail['likecount'] = 0;
        }

        if (isset($flag[0])) {
            $detail['flag'] = true;
        } else {
            $detail['flag'] = false;
        }

        if (isset($flagcount[0])) {
            $detail['flagcount'] = count($flagcount);
        } else {
            $detail['flagcount'] = 0;
        }

        return view('projects.detail', $detail);
    }

///////////////////////////////////////////////////////////

    public function tagProjects($tag)
    {
        $info = [];
        $info['tag'] = $tag;

        $projects = \DB::table('project_images')
            ->join('users', 'users.userId', '=', 'project_images.userId')
            ->select('users.username', 'users.userId', 'project_images.*')
            ->where('project_images.tags', 'like', '%' . $tag . '%')
            ->orderBy('created_at', 'desc')
            ->get();


        return view('projects.tag', compact('projects', 'tag'));
    }

///////////////////////////////////////////////////////////

    public function showEditProject($id)
    {
        if (!Auth::check()) {
            return redirect('/')->withErrors(["You're not logged in."]);
        }

        $project = \DB::table('project_images')->where('projectId', $id)->select('projectId', 'userId', 'title', 'description', 'image', 'tags', 'created_at')->get();

        $detail = [];
        $detail['projectId'] = $project[0]->projectId;
        $detail['image'] = $project[0]->image;
        $detail['title'] = $project[0]->title;
        $detail['description'] = $project[0]->description;
        $detail['tags'] = $project[0]->tags;

        return view('projects.editproject', $detail);
    }

    public function editProject(ProjectRequest $request)
    {
        $user = Auth::user()->userId;

        $projectId = $request->id;

        $title = $request->get("title");
        $description = $request->get("description");
        $tags = $request->get("tags");

        if (!empty($title)) {
            \DB::table('project_images')
                ->where('userId', $user)
                ->where('projectId', $projectId)
                ->update(['title' => $title]);
        }

        if (!empty($description)) {
            \DB::table('project_images')
                ->where('userId', $user)
                ->where('projectId', $projectId)
                ->update(['description' => $description]);
        }

        if (!empty($tags)) {
            \DB::table('project_images')
                ->where('userId', $user)
                ->where('projectId', $projectId)
                ->update(['tags' => $tags]);
        }

        return \Redirect::to("/projects/$projectId");
    }

    public function deleteProject()
    {
        if (Auth::check()) {
            $projectId = Input::get('projectId');

            \DB::table('project_images')->where('projectId', $projectId)->delete();
        }
    }

    public function like()
    {

        $projectId = Input::get('projectId');
        $userId = \Auth::id();

        $project = Project::find($projectId);

        if (!Auth::check()) {
            return redirect('/')->withErrors(["You're not logged in."]);
        }

        UserExperience::addStats($project->user->userId, "likes", 50);

        $like = new ProjectLike();
        $like->userId = $userId;
        $like->projectId = $projectId;
        $like->save();

        DB::table('project_images')->where('projectId', $projectId)->increment('likeCount');

    }

    public function dislike()
    {
        $projectId = Input::get('projectId');
        $userId = \Auth::id();

        $project = Project::find($projectId);

        if (!Auth::check()) {
            return redirect('/')->withErrors(["You're not logged in."]);
        }

        $like = ProjectLike::where('userId', $userId)->where('projectId', $projectId)->first();
        $like->delete();

        UserExperience::addStats($project->user->userId, "likes", -50);

        DB::table('project_images')->where('projectId', $projectId)->decrement('likeCount');
    }

    public function comment(Request $request)
    {
        $userId = \Auth::id();
        $projectId = $request->get("projectId");
        $comments = $request->get("comment");

        $project = Project::find($projectId);

        if (!Auth::check()) {
            return redirect('/')->withErrors(["You're not logged in."]);
        }

        UserExperience::addStats($project->user->userId, "comments", 150);

        $comment = new ProjectComment();
        $comment->userId = $userId;
        $comment->projectId = $projectId;
        $comment->comment = $comments;
        $comment->save();
    }

    public function showActivity()
    {

        if (!Auth::check()) {
            return redirect('/')->withErrors(["You're not logged in."]);
        }
        $userId = \Auth::id();
        $activities = Activity::where('userId', $userId)->orderBy('created_at', 'desc')->take(15)->get();
        Activity::markAllAsSeen(\Auth::user());

        /*
            Select activities.type, users.username, project_images.title, activities.created_at, activities.comment
            from activities
            inner join project_images on project_images.projectId = activities.projectId
            inner join users on users.userId = activities.userId
            where project_images.userId = 1;
        */


        //dd($activities);

        return view('projects.activity', compact('activities'));

    }

    public function myLikes()
    {
        $userId = \Auth::id();

        $likes = \DB::table('likes')
            ->join('project_images', 'project_images.projectId', '=', 'likes.projectId')
            ->join('users', 'users.userId', '=', 'likes.userId')
            ->where('project_images.userId', $userId)
            ->orderby('likes.created_at', 'desc')
            ->get(['likes.projectId', 'username', 'project_images.title', 'likes.created_at']);


        return view('projects.myLikes', compact('likes'));
    }

    public function flag()
    {
        $projectId = Input::get('projectId');
        $userId = \Auth::id();
        $commentId = Input::get('commentId');

        if (!Auth::check()) {
            return redirect('/')->withErrors(["You're not logged in."]);
        }

        $flag = new ProjectFlag();
        $flag->userId = $userId;
        $flag->projectId = $projectId;
        $flag->commentId = $commentId;
        $flag->save();

        DB::table('comments')->where('projectId', $projectId)->where('id', $commentId)->increment('flagCount');
    }

    public function seenNotification()
    {

        Activity::markAllAsSeen(\Auth::user());

    }
}
