<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\RegisterUserRequest;
use App\User;
use App\UserExperience;
use App\UserInvite;
use App\UserReferfriend;
use Auth;
use GuzzleHttp\Psr7\Request;
use Mail;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Intervention\Image\Facades\Image;
use MandrillMail;
use Config;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @param Request $request
     */
    protected $redirectPath = '/homepage';
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'username' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
    public function postRegister(RegisterUserRequest $request)
    {
        $mail = $request->get("email");
        $user = new User();
        $user->email = $mail;

        $isStudent = str_contains($mail, "@student.thomasmore.be");

        if ($isStudent)
        {
            $validator = $this->validator($request->all());

            if ($validator->fails())
            {
                $this->throwValidationException(
                    $request, $validator
                );
            }
            $checkforreferal = UserReferfriend::where('email',$mail)->count();

            if($checkforreferal === 1)
            {
                $refer =  \DB::table('user_referfriend')
                        ->where('email', "=", $mail)
                        ->get();
                UserExperience::addStats($refer[0]->userId,'invites',1000);

                \DB::table('user_referfriend')
                    ->where('email', "=", $mail)
                    ->update(array('check' => 1));

            }

            $template_content = [];

            $message = array(
                'subject' => 'Welkom To Laddder',
                'from_email' => 'noreplay@laddder.be',
                'from_name' => 'Laddder info',
                'to' => array(
                    array(
                        'email' => $user->email,
                        'name' => $user->username,
                        'type' => 'to'
                    )
                ),
                'merge_vars' => array(
                    array(
                        'rcpt' => $mail,
                        'vars' => array(
                            array(
                                'name' => 'USERNAME',
                                'content' => $request->get('name'),
                            )
                        )
                    )
                )


            );
            MandrillMail::messages()->sendTemplate('WelcomeToLaddder', $template_content, $message);


            Auth::login($this->create($request->all()));

            $username = $request->get("name");
            $img = \DefaultProfileImage::create($username, 200, '#000', '#FFF');
            $filename  = time() . '.png';
            $image = $img->encode();
            $path = public_path('profilepics/' . $filename);
            Image::make($image->save($path));

            $userId = Auth::user()->userId;
            \DB::table('users')
                  ->where('userId', $userId)
                  ->update(['image' => $filename]);





            return redirect($this->redirectPath())->with('message', "Your account has been created, and you are now logged in.");

        } else
        {
            $userInvite = new UserInvite();
            $userInvite->email = $mail;
            $userInvite->save();

            return redirect('/register')->with('message', "You've been added to the queue, you will receive a mail when Laddder is open for everyone!");
        }
    }
}
