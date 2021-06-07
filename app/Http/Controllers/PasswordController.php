<?php

namespace App\Http\Controllers;
use App\Mail\ChistyzMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Hash;
use App\PasswordReset;
use App\User;

class PasswordController extends Controller
{
    public function index(Request $request)
    {
        $valid = $request->validate([
            'email'=> 'required|email|exists:users,email',
        ]);

        $prev = PasswordReset::where('email',$request->email)->first();

        if($prev)
        {
            $date = date('U', time());
            $prevTime = strtotime($prev->created_at);
            $timeDiff = (int)(($date - $prevTime));
            if($timeDiff<60)
            {
                return response('wait');
            }
            else
            {
                $prev->delete();
                $newToken = new PasswordReset;
                $newToken->email = $request->email;
                $newToken->token = bin2hex(random_bytes(16));
                $newToken->save();
                Mail::to('chistyz10@gmail.com')->send(new ChistyzMail([
                    "header" => 'Password Reset Form',
                    "body" => "<p>This is a Password Reset Request from Chistyz, Please Ignore If You didn't request this</p>
                               <p> To Reset Password Clicks on the Button Below. Token Expiration Time is 5-6 mint </p>
                               <br/>
                               <a href='http://localhost:8000/reset-password/$newToken->token'><button style='background-color: #4CAF50; /* Green */
                               border: none;
                               color: white;
                               padding: 15px 32px;
                               text-align: center;
                               text-decoration: none;
                               display: inline-block;
                               font-size: 16px;'>LocalHost</button></a>
                               <br/>
                               <a href='https://www.chistyz.ml/reset-password/$newToken->token'><button style='background-color: red; /* Green */
                               border: none;
                               color: white;
                               padding: 15px 32px;
                               text-align: center;
                               text-decoration: none;
                               display: inline-block;
                               margin-top:20px;
                               font-size: 16px;'>LiveServer</button></a>
                                "
                ]));
                return response('Success');
            }
            
            
        }
        else
        {
            $newToken = new PasswordReset;
            $newToken->email = $request->email;
            $newToken->token = bin2hex(random_bytes(16));
            $newToken->save();
            return response('Success');
        }


        

       
    }

    public function tokenValidate(Request $request,$token)
    {
        $getToken = PasswordReset::where('token',$token)->first();
        if($getToken)
        {
            $date = date('U', time());
            $prevTime = strtotime($getToken->created_at);
            $timeDiff = (int)(($date - $prevTime));
            if($timeDiff>360)
            {
                return response('expired');
            }
            else
            {

                $data = [
                    'valid' => true,
                    'email' => $getToken->email,
                ];
                return response()->json($data);
            }
        }
        else
        {
            return response('false');
        }

    }

    public function passwordResetVerify(Request $request)
    {
        $valid = $request->validate([
            'password' => 'required|confirmed|min:6|max:100',
        ]);

        $tokenMail = PasswordReset::where('token',$request->token)->first();
        
        $date = date('U', time());
        $prevTime = strtotime($tokenMail->created_at);
        $timeDiff = (int)(($date - $prevTime));
        
        if($timeDiff>360)
        {
            return response('expired');
        }
        else
        {
            $user = User::where('email',$tokenMail->email)->first();
            $user->password = Hash::make($request->password);
            $user->save();
            return response('Success');

        }


    }
}
