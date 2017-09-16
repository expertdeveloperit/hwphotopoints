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
            return response()->json(compact('token','user','status'));    
        }else{
            JWTAuth::setToken($token)->invalidate();
            return response()->json(['error' => 'invalid_credentials'], 401);
        }	
        // all good so return the token
        
    }
}
