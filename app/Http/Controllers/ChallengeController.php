<?php

namespace App\Http\Controllers;

use App\Project;
use App\UserExperience;
use App\Challenge;
use App\Entry;
use App\EntryVote;
use App\Activity;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Input;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Redirect;
use Log;
use DB;
use App\Http\Requests\NewChallengeRequest;
use App\Http\Requests\ParticipateChallengeRequest;
use Carbon;
use DateTime;
use DateInterval;

class ChallengeController extends Controller
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
    
    public function create()
    {

        if (!Auth::check()) {
            return redirect('/')->withErrors(["You're not logged in."]);
        }

        $admin = Auth::user()->admin;

        if ($admin != 1) {
            return redirect('/')->withErrors(["You're not allowed to visit this page."]);
        }

        return view('challenge.create');

    }

    public function createPost(NewChallengeRequest $request)
    {
        $pUserId = Auth::user()->userId;

        $messages = [
            'pTitle.required' => "Don't forget to give your challenge a name." ,
            'pTitle.max' => "Please give your challenge a shorter name. Like, 'Bob'." ,
            'pBanner.required' => "Please select a banner to feature your challenge." ,
            'pDescription.required' => "Please describe this challenge." ,
            'pStart.required' => "Please select a start date for this challenge." ,
            'pEnd.required' => "Please select an end date for this challenge." ,
        ];
        
        $this->validate($request, [
            'pTitle' => 'required|max:255',
            'pBanner' => 'required',
            'pDescription' => 'required',
            'pStart' => 'required',
            'pEnd' => 'required',
        ], $messages);

        if (Input::file()) {

            $image = Input::file('pBanner');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = public_path('challenge_banners/' . $filename);
            Image::make($image->getRealPath())->save($path);
        }

        $pTitle = $request->get("pTitle");
        $pDescription = $request->get("pDescription");
        $pBanner = $filename;
        $pStart = $request->get("pStart");
        $pEnd = $request->get("pEnd");

        $challenge = new Challenge();
        $challenge->title = $pTitle;
        $challenge->description = $pDescription;
        $challenge->banner = $pBanner;
        $challenge->startdate = $pStart;
        $challenge->enddate = $pEnd;

        $challenge->save();
        return Redirect::to('/homepage');

    }

    public function showChallenge($id)
    {

        if (!Auth::check()) {
            return redirect('/')->withErrors(["You're not logged in."]);
        }

        $challenge = \DB::table('challenges')->where('challengeId', $id)->select('challengeId', 'title', 'description', 'banner', 'startdate', 'enddate', 'created_at')->get();

        if(Carbon\Carbon::today()->format('Y-m-d') < $challenge[0]->startdate)
        {
            return redirect('/homepage')->withErrors(["This challenge isn't open for public yet."]);
        }

        $data = [];
        $data['challengeId'] = $challenge[0]->challengeId;
        $data['title'] = $challenge[0]->title;
        $data['description'] = $challenge[0]->description;
        $data['banner'] = $challenge[0]->banner;
        $data['startdate'] = $challenge[0]->startdate;
        $data['enddate'] = $challenge[0]->enddate;
        $data['created_at'] = $challenge[0]->created_at;

        if(Carbon\Carbon::today()->format('Y-m-d') > $challenge[0]->enddate)
        {
            $data['status'] = 'over';
        }
        else
        {
            $data['status'] = 'ongoing';
        }

        return view('challenge.detail', $data);

    }

    public function participate(ParticipateChallengeRequest $request)
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
        $challengeId = $request->get("challengeId");
        
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

        $entry = new Entry();
        $entry->projectId = $id;
        $entry->challengeId = $challengeId;
        $entry->save();
        $redirecturl = '/projects/' . $id;
        return Redirect::to($redirecturl);
    }

    public function showEntries($id)
    {

        if (!Auth::check()) {
            return redirect('/')->withErrors(["You're not logged in."]);
        }

        $challenge = \DB::table('challenges')->where('challengeId', $id)->select('startdate', 'enddate')->get();

        if(Carbon\Carbon::today()->format('Y-m-d') > $challenge[0]->enddate)
        {
            $entries = DB::table('entries')->where('challengeId', $id)->join('project_images', 'project_images.projectId', '=', 'entries.projectId')
                ->select('project_images.*', 'entries.id')->orderBy('project_images.voteCount', 'desc')
                ->get();

            $pUserId = Auth::id();
            $vote = DB::table('challenge_votes')->where('userId', $pUserId)
                ->select('id', 'userId', 'projectId')
                ->get();

            $stopdate = new DateTime($challenge[0]->enddate);
            $stopdate->add(new DateInterval('P10D'));
            $stopdate = $stopdate->format('Y-m-d');
            if(Carbon\Carbon::today()->format('Y-m-d') > $stopdate)
            {
                $data['status'] = 'over';
            }
            else
            {
                $data['status'] = 'ongoing';
            }

            return view('challenge.entries', compact('entries', 'id', 'data', 'vote'));
        }
        else
        {
            return redirect('/challenge/' . $id)->withErrors(["Voting isn't open for this challenge yet."]);
        }

    }

    public function vote()
    {

        $projectId = Input::get('projectId');
        $userId = \Auth::id();

        if (!Auth::check()) {
            return redirect('/')->withErrors(["You're not logged in."]);
        }

        $vote = new EntryVote();
        $vote->userId = $userId;
        $vote->projectId = $projectId;
        $vote->save();

        DB::table('project_images')->where('projectId', $projectId)->increment('voteCount');

    }

    public function unvote()
    {
        $projectId = Input::get('projectId');
        $userId = \Auth::id();


        if (!Auth::check()) {
            return redirect('/')->withErrors(["You're not logged in."]);
        }

        \DB::table('challenge_votes')->where('userId', $userId)->where('projectId', $projectId)->delete();
        DB::table('project_images')->where('projectId', $projectId)->decrement('voteCount');

    }

}
