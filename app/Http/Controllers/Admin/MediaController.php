<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Media;
use Session;
use Validator;
use Redirect;
use Input;
use File;
class MediaController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth');
    }

    // all series list
    public function index(){
    	$media = Media::paginate(2);
    	return view('admin.media.index',['media'=>$media]);
    }

    public function add(){
        return view('admin.media.add');
    }

    public function create(Request $request){
        $dir = date('Y').'/'.date('m').'/';
        $destinationPath = public_path('/uploads/media/').$dir;
        if(!is_dir($destinationPath)){
            File::makeDirectory($destinationPath, $mode = 0777, true, true);
        }
        $file = $request->file('media');
        $name = $file->getClientOriginalName();    

        if(file_exists($destinationPath.$name)){
            $name = time().'-'.$name;
        }

        $file = $file->move($destinationPath, $name);

        $media = new Media;
        $media->name = $name;
        $media->directory = $dir;
        $media->save();
        Session::flash('message', 'Image has been uploaded.'); 
        return redirect()->route('mediaAddView');
    }

    public function delete(Request $request,$id)
    {   
        if($id){
           Media::find($id)->delete(); 
        }

        Session::flash('message', 'Image has been deleted.'); 
        return Redirect::back();
    }

}	
