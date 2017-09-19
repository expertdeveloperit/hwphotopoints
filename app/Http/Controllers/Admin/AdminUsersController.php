<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\UserMeta;
use Session;
use Validator;
use Redirect;
use Input;
use Hash;
class AdminUsersController extends Controller
{


    public function index(){
    	$users = User::all();

    	return view('admin.users.index',['users'=>$users]);
    }

    public function edit(Request $Request, $id = null)
	{
		$user = User::find($id);

    	return view('admin.users.createupdate',['user'=>$user]);
    }

    public function create(Request $Request, $id = null)
	{
		
    	return view('admin.users.createupdate');
    }

    public function update(Request $request, $id = null)
	{	

		$data = $request->all();
		if($id){
			$user = User::find($id);
			$user->name = $data['name'];
			$user->email = $data['email'];
			if($data['password'] != ""){
				$user->password = Hash::make($data['password']);
			}
			$user->save();

			$userMeta = UserMeta::where('user_id' , '=', $id);
			$userMeta->role = $data['role'];
			$userMeta->status = $data['status'];
			$userMeta->save();
			Session::flash('message', ' User has been updated!');
	    	return redirect()->route('usersEdit',$id);
    	}else{

    		$user = new User;
			$user->name = $data['name'];
			$user->email = $data['email'];
			if($data['password'] != ""){
				$user->password = Hash::make($data['password']);
			}
			$user->save();

			$userMeta = new UserMeta;
			$userMeta->role = $data['role'];
			$userMeta->status = $data['status'];
			$userMeta->first_name = '';
			$userMeta->last_name = '';
			$userMeta->country = '';
			$userMeta->biography = '';
			$userMeta->profile_img = '';
			$user->userMeta()->save($userMeta);
			Session::flash('message', ' User has been saved!');
	    	return redirect()->route('usersEdit',$user->id);	
    	}
    }

    public function delete(Request $request, $id = null)
    {
    	if($id){
    		User::destroy($id);     
    		Session::flash('message',' User has been deleted!');
    	}
    	return redirect()->route('usersList');

    }
}	
