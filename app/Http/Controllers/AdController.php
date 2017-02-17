<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Requests;
use App\Http\Requests\CreateAdRequest;
use App\Advertisement;
use App\User;
use Input;
use Mail;
use Validator;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\StoreProjectRequest;
use DB;
use App\Activity;
use MandrillMail;
use Config;


class AdController extends Controller
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
    
    public function show(){

        $ads = \DB::table('advertisements')->get();

        if(count($ads)>=3)
        {
            return redirect('/homepage')->withErrors(['There are no free advertisement slots available. Please come back later!']);
        }
        return view ("ad.create");
    }
    
    public function success(){


        return view ("ad.succes");
    }

    public function create(CreateAdRequest $request)
    {
        
        $messages = [
            'image_file.required' => "Please select an image for your advertisement." ,
        ];
        
        $this->validate($request, [
            'image_file' => 'required',
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

                    $sTempFileName = public_path('ad_images/' . $sLastPartFileName);
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


        $aName = $request->get("aName");
        $aImage = $sLastPartFileName;
        $aLink = $request->get("aLink");
        $aEmail = $request->input('stripeEmail');;

        $ad = new Advertisement();
        $ad->name = $aName;
        $ad->image = $aImage;
        $ad->link = $aLink;
        $ad->email = $aEmail;
        \Stripe\Stripe::setApiKey(env('STRIPE_KEY'));
        $token  = $request->input('stripeToken');

        $customer = \Stripe\Customer::create(array(
            'email' =>$aEmail,
            'card'  => $token
        ));
        $charge = \Stripe\Charge::create(array(
            'customer' => $customer->id,
            'amount'   => 5000,
            'currency' => 'EUR'
        ));

        $template_content = [];

        $message = array(
            'subject' => 'Your transaction for advertisement was succesfull @laddder',
            'from_email' => 'noreply@laddder.be',
            'from_name' => 'Laddder advertisement',
            'to' => array(
                array(
                    'email' => $aEmail,
                    'name' => $aName,
                    'type' => 'to'
                )
            ),
            'merge_vars' => array(
                array(
                    'rcpt' => $aEmail,
                    'vars' => array(
                        array(
                            'name' => 'USERNAME',
                            'content' => $request->get('name'),
                        )
                    )
                )
            )


        );
        MandrillMail::messages()->sendTemplate('Payment_Succes', $template_content, $message);

        $ad->save();



        $redirecturl = '/ads/success';
        return Redirect::to($redirecturl);

    }
    public function pay(){
        dd(Input::all());
    }

}
