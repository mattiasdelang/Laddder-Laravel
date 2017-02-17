<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Http\Requests\referFriendRequest;
use App\UserExperience;
use App\Http\Requests\ProfileUserRequest;
use App\Http\Requests\ChangePwRequest;
use App\User;
use App\UserReferfriend;
use Input;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use DB;
use Carbon;
use DateTime;
use DateInterval;

class UsersController extends Controller
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
    public function register()
    {
        return view('users.register');
    }

    public function showReferfriend()
    {
        if (!Auth::check()) {
            return redirect('/')->withErrors(["You're not logged in."]);
        }

        $user = Auth::id();

        $referfriend = UserReferfriend::where('userId', $user)->get();

        return view('users.referfriend', compact('referfriend'));
    }

    public function home()
    {

        $projectlist = DB::table('project_images')
                        ->select('tags')
                        ->get();
        $allTags = [];
        $counter = 0;
        foreach($projectlist as $project)
        {
            $projectTags = $project->tags;
            $iets = strpos($projectTags,'#');

            if(!$iets)
                $allTags[$counter] = explode(',', $projectTags);

            $counter++;
        }

        $allTags = call_user_func_array('array_merge', $allTags);
        $tagCount = array_count_values ($allTags);
        arsort($tagCount);
        $tagList = array_keys($tagCount);

        $projecten = DB::table('project_images')
            ->join('users', 'users.userId', '=', 'project_images.userId')
            ->select('users.username', 'users.userId', 'project_images.*')
            ->orderBy('created_at', 'desc')
            ->paginate(17);

        $data = \DB::table('challenges')->where('startdate', '<=', Carbon\Carbon::today()->format('Y-m-d'))->select('title', 'banner', 'challengeId')->take(1)->orderBy('startdate', 'desc')->get();

        $winnerdate = \DB::table('challenges')->where('enddate', '<=', Carbon\Carbon::today()->format('Y-m-d'))->select('challengeId', 'enddate')->orderBy('enddate', 'desc')->get();

        $stopdate = new DateTime($winnerdate[0]->enddate);
        $stopdate->add(new DateInterval('P10D'));
        $stopdate = $stopdate->format('Y-m-d');

        // ######################################## ADVERTISEMENTS ########################################
        $ads = \DB::table('advertisements')->get();

        foreach ($ads as $ad) {
            $enddate = new DateTime($ad->created_at);
            $interval = new DateInterval('P1M');
            $enddate->add($interval);
            $nowdate = Carbon\Carbon::today()->format('Y-m-d');

            if ($nowdate > $enddate->format('Y-m-d')) {
                \DB::table('advertisements')->where('adId', $ad->adId)->delete();
                $ads = \DB::table('advertisements')->get();
            }
        }
        // ################################################################################################
        if (Carbon\Carbon::today()->format('Y-m-d') > $stopdate) {
            $winnerdata = DB::table('entries')->where('challengeId', $winnerdate[0]->challengeId)->join('project_images', 'project_images.projectId', '=', 'entries.projectId')
                ->select('project_images.*', 'entries.id')->take(1)->orderBy('project_images.voteCount', 'desc')
                ->get();

            if(count($winnerdata) > 0)
            {
                $winnername = \DB::table('users')->where('userId', $winnerdata[0]->userId)->select('username')->get();
            }
            else
            {
                $winnername = 0;
            }

            return view('home', compact('projecten', 'data', 'winnerdata', 'winnername', 'ads','tagList'));
        } else {
            $winnerdata = DB::table('entries')->where('challengeId', $winnerdate[1]->challengeId)->join('project_images', 'project_images.projectId', '=', 'entries.projectId')
                ->select('project_images.*', 'entries.id')->take(1)->orderBy('project_images.voteCount', 'desc')
                ->get();

            if(count($winnerdata) > 0)
            {
                $winnername = \DB::table('users')->where('userId', $winnerdata[0]->userId)->select('username')->get();
            }
            else
            {
                $winnername = 0;
            }

            $user = \Auth::user();

            return view('home', compact('projecten', 'data', 'winnerdata', 'winnername', 'ads','tagList'));

        }
    }

    public function editProfile()
    {
        if (!Auth::check()) {
            return redirect('/')->withErrors(["You're not logged in."]);
        }

        return view('users.editprofile');
    }

    public function editProfileUser(ProfileUserRequest $request)
    {
        $user = Auth::user()->userId;

        //desired image result dimensions
        $iWidth = 400;
        $iHeight = 400;

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

                    $sTempFileName = public_path('profilepics/' . $sLastPartFileName);
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


        $portfolio = $request->get("portfolio");
        $twitter = $request->get("twitter");
        $facebook = $request->get("facebook");
        $opleiding = $request->get("opleiding");

        if (isset($sLastPartFileName)) {
            \DB::table('users')
                ->where('userId', $user)
                ->update(['image' => $sLastPartFileName]);
        }

        if (!empty($portfolio)) {
            \DB::table('users')
                ->where('userId', $user)
                ->update(['portfolio' => $portfolio]);
        }

        if (!empty($twitter)) {
            \DB::table('users')
                ->where('userId', $user)
                ->update(['twitter' => $twitter]);
        }

        if (!empty($facebook)) {
            \DB::table('users')
                ->where('userId', $user)
                ->update(['facebook' => $facebook]);
        }

        if (!empty($opleiding)) {
            \DB::table('users')
                ->where('userId', $user)
                ->update(['opleiding' => $opleiding]);
        }

        return \Redirect::to("/user/profile/$user");
    }


    public function login()
    {
        if (Auth::check()) {
            return redirect('/homepage')->withErrors(['You are already logged in.']);
        }

        return view('users.login');
    }

    public function changePW()
    {
        if (!Auth::check()) {
            return redirect('/')->withErrors(['You need to be logged in.']);
        }

        return view('users.changepw');
    }

    public function loginPost(Request $request)
    {
        $email = $request->get("email");
        $password = $request->get("password");

        if (Auth::attempt(['email' => $email, 'password' => $password])) {

            $userId = Auth::id();

            UserExperience::addStats($userId, "logins", 2);

            return redirect()->intended('/homepage');
        }

        return redirect('/login')->with('message', "Username or password is wrong!");
    }

    public function profile($id)
    {
        $user = \DB::table('users')->where('userId', $id)->select('username', 'image', 'portfolio', 'twitter', 'facebook', 'opleiding')->get();
        
        $projecten = DB::table('project_images')
            ->where('userId', $id)
            ->orderBy('created_at', 'desc')
            ->paginate(2);
        $activities = Activity::where('userId', $id)->orderBy('created_at', 'desc')->take(5)->get();
        
        if (\Auth::id() === $id)
            Activity::markAllAsSeen(User::find($id));

        $profile = [];
        $profile['userId'] = $id;
        $profile['username'] = $user[0]->username;
        $profile['image'] = $user[0]->image;
        $profile['portfolio'] = $user[0]->portfolio;
        $profile['twitter'] = $user[0]->twitter;
        $profile['facebook'] = $user[0]->facebook;
        $profile['opleiding'] = $user[0]->opleiding;


        $profile = (object)$profile;
        

        $user = User::find($id);

        return view('users.profile', compact('profile', 'activities', 'projecten', 'user', 'apiCalls'));
    }

    public function changePWPost(ChangePwRequest $request)
    {
        $user = $request->user();

        $username = $request->get("username");
        $current = $request->get("current");
        $newPassword = $request->get("password");

        $hashedpassword = $user->password;

        if (!Hash::check($current, $hashedpassword)) {
            return \Redirect::back()->withErrors('Current password invalid!');
        }

        $img = \DefaultProfileImage::create($username, 200, '#000', '#FFF');
        $filename = time() . '.png';
        $image = $img->encode();
        $path = public_path('profilepics/' . $filename);
        Image::make($image->save($path));

        $userId = Auth::user()->userId;

        \DB::table('users')
            ->where('userId', $userId)
            ->update(['image' => $filename]);

        $user->password = \Hash::make($newPassword);
        $user->username = $username;
        $user->save();
        return \Redirect::to("/user/edit-profile");
    }

    public function showApikey()
    {
        if (!Auth::check()) {
            return redirect('/')->withErrors(['You need to be logged in.']);
        }

        $user = Auth::user();
        $apikey = $user->apikey->key;
        
        
        $id = Auth::id();
        $calls = \DB::table('user_apikey')->where('userId', $id)->select('calls')->get();
        
        $apiCalls = [];
        $apiCalls['calls'] = $calls[0]->calls;
        $apiCalls = (object)$apiCalls;

        return view('users.apikey', compact('apikey', 'apiCalls'));
    }

    public function inviteFriend(referFriendRequest $request)
    {
        $email = $request->get("email");
        $userid = Auth::id();


        $refer = new UserReferfriend();
        $refer->userId = $userid;
        $refer->email = $email;
        $refer->check = 0;
        $refer->save();

        return \Redirect::to("/referfriend")->with('message', "We have send an invite!");
    }
}
