<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use App\Series;
use App\SeriesPosts;
use Session;
use Validator;
use Redirect;
use Input;
use Auth;
use App\User;
use App\UserMeta;
use Hash;

class UserAuthenticate extends Controller
{
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user

            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid login detail.','status'=>false]);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token','status'=>false]);
        }

        $user = Auth::user();

        if($user->userMeta->role == "1" || $user->userMeta->role == "2"){
            $status = true;
            $user['role'] = "admin";
            return response()->json(compact('token','user','status'));    
        }else{
            $status = true;
            $user['role'] = "visitor";
            return response()->json(compact('token','user','status'));    
            // JWTAuth::setToken($token)->invalidate();
            // return response()->json(['error' => "Your can't access this area.",'status'=>false]);
        }	
        // all good so return the token
        
    }


    public function forgetPassword(Request $request)
    {
        $data = $request->all();
        $user = User::where('email',$data['email'])->first();
        if($user){
            $key = time().substr(base64_encode(crypt('', '')), 0, 32);
            $meta = UserMeta::where('user_id',$user->id)->first();
            $meta->forget_pass = $key;
            $meta->save();

            $to = $user->email;
            $subject = "HW Photo Points Reset Password";
            $link = "http://wphackstop.com/reset/password/".$key;
            $txt = "To reset your password please click on this <a href=".$link.">link</a> and follow the instructions.";
            $headers = "From: hw@example.com" . "\r\n" .
            "CC: somebodyelse@example.com". "\r\n".
            "Content-type: text/html; charset=iso-8859-1";
            
            mail($to,$subject,$txt,$headers);
            $msg = "We have sent you an email, please use link to reset password.";
            $status = "true";
            return response()->json(compact('msg','status','link'));            
        }else{
            $msg = "This Email does't exist.";
            $status = "false";
            return response()->json(compact('msg','status'));            
        }
    }

    public function validateResetKey(Request $request , $key = null)
    {
        if($key){
            $meta = UserMeta::where('forget_pass',$key)->first();
            if($meta){
                $msg = "";
                $status = "true";
                return response()->json(compact('msg','status'));                   
            }else{
                $msg = "This url has expired.";
                $status = "false";
                return response()->json(compact('msg','status'));                   
            }
        }
    }

    public function resetPassword(Request $request)
    {
        $data = $request->all();
          $meta = UserMeta::where('forget_pass',$data['key'])->first();
            if($meta){
                $user = User::find($meta->user_id)->first();
                $user->password = Hash::make($data['password']);
                $user->save();
                $meta->forget_pass = "";
                $meta->save();
                $msg = "Password has reset.";
                $status = "true";
                return response()->json(compact('msg','status'));                   
            }else{
                $msg = "The reset url has expired.";
                $status = "false";
                return response()->json(compact('msg','status'));                   
            }
    }
}
