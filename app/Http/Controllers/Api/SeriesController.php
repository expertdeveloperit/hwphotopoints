<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use App\Series;
use App\SeriesPosts;
use App\SeriesPostViews;
use App\MediaInformation;
use Image;
use Session;
use Validator;
use Redirect;
use Input;
use Auth;
use Storage;
class SeriesController extends Controller
{   
    // get minimum year value
    public function getYear(Request $request)
    {
    	$data = $request->all();
    	$seriesName = $data['series'];
    	$seriesData = Series::where('name','=',$seriesName)->first();
    	$years = SeriesPosts::select('year')->where('series_id','=',$seriesData->id)->orderBy('year','Asc')->first();
		
		return response()->json(compact('years'));
    }

    //get location name
    public function getLocations(Request $request)
    {	
    	$data = $request->all();
    	$year = $data['year'];
    	$series = $data['series'];

    	$posts = SeriesPosts::select('title')->where('year','=',$year)->get();
    	if($posts->count() > 0){
			return response()->json(compact('posts'));	
		}else{
			$seriesData = Series::where('name','=',$series)->first();
			$posts = SeriesPosts::select('title')->where('series_id','=',$seriesData->id)->get();
			return response()->json(compact('posts'));	
		}
    }

    //get image type
    public function imageType(Request $request)
    {
    	$data = $request->all();
    	$year = $data['year'];
    	$location = $data['location'];

    	$postId = SeriesPosts::select('id')->where('title','=',$location)->where('year','=',$year)->first();
    	//return $postId;
        if($postId){
            if($postId->count() > 0){
        	   $getType = SeriesPostViews::where('series_list_id','=',$postId->id)->get();
            }   
        }else{
            $postId = SeriesPosts::select('id')->where('year','<',$year)->first();    
            $getType = SeriesPostViews::where('series_list_id','=',$postId->id)->get();
        }
        $imageTypes = array();
        foreach ($getType as $key => $value) {
            $imageTypes[] = $value['image_view'];
        }
        $types = array_unique($imageTypes);
    	return response()->json(compact('types'));     		
    }


    //get images views name
    public function imageViews(Request $request)
    {
        $data = $request->all();
        $year = $data['year'];
        $location = $data['location'];
        $image_view = $data['image_view'];

        $postId = SeriesPosts::select('id')->where('title','=',$location)->where('year','=',$year)->first();
         if($postId){
            if($postId->count() > 0){
               $getValue = SeriesPostViews::where('series_list_id','=',$postId->id)->where('image_view','=',$image_view)->get();
            }   
        }else{
            $postId = SeriesPosts::select('id')->where('year','<',$year)->first();    
            $getValue = SeriesPostViews::where('series_list_id','=',$postId->id)->where('image_view','=',$image_view)->get();
        }
        
        $imageValues = array();
        foreach ($getValue as $key => $value) {
            if($image_view =="PAN"){
                $imageValues[] = $value['value']." ".$value['pan_view'];
            }else $imageValues[] = $value['value'];
        }
        $values = array_unique($imageValues);
        return response()->json(compact('values'));          
    }


    //get P series Posts list on 'Photos Point Page'

    public function pSeriesList(Request $request)
    {
            
        $seriesData = Series::where('name','=','P')->first();
        $posts = SeriesPosts::select('title')->where('series_id','=',$seriesData->id)->get();
        
        return response()->json(compact('posts'));
    }

    //p series Posts  Detail
    public function pSeriesPostsDetail(Request $request){
        $data = $request->all();
        $postName = $data['postname'];                    
        $userId = Auth::user()->id;    
        $media = MediaInformation::where('user_id','=',$userId)->where('series','=','P')->where('post_name','=',$postName)->get();
        
        return response()->json(compact('media'));
    }

    //another series detail
    public function anotherSeriesPostsDetail(Request $request){
        $data = $request->all();
        $seriesName = $data['seriesname'];                    
        $userId = Auth::user()->id;    
        $media = MediaInformation::where('user_id','=',$userId)->where('series','=',$seriesName)->get();
        
        return response()->json(compact('media'));
    }    

    //when all form data submited

    public function uploadData(Request $request)
    {
        $data = $request->all();

        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $year = $data['year'];
        $series = $data['series'];
        $location = $data['location'];
        $season = $data['season'];
        $image_view = $data['image_view'];
        $view = $data['view'];


        $imageName = $year.'-'.$series.'-'.$location.'.'.$request->image->getClientOriginalExtension();
        $image = $request->file('image');
        $thumb = Image::make($image->getRealPath())->resize(225, 150, function ($constraint) {
            $constraint->aspectRatio(); //maintain image ratio
        });

        $destinationPath = public_path('/uploads/');
        $filePathSave = $destinationPath.'/thumb-'.$imageName;
        $thumb->save($filePathSave);

        $thumbName = $year.'/'.$series.'/'.'thumbs/'.$imageName;
        Storage::disk('s3')->put($thumbName, file_get_contents($filePathSave),'public');

        $originalImageName = $year.'/'.$series.'/'.$imageName;
        Storage::disk('s3')->put($originalImageName, file_get_contents($image),'public');

        $originalImageUrl = Storage::disk('s3')->url($originalImageName);
        $thumbImageUrl = Storage::disk('s3')->url($thumbName);

        if(file_exists($filePathSave)){
            unlink($filePathSave);
        }

        //save the information
        $user = Auth::user(); 
        $mediaSave = new MediaInformation;
        $mediaSave->user_id = $user->id;
        $mediaSave->file_name = $imageName;
        $mediaSave->file_location_aws = $originalImageUrl;
        $mediaSave->file_thumb_location_aws = $thumbImageUrl;
        $mediaSave->uploaded_by = $user->name;
        $mediaSave->uploading_date = date('yyyy-mm-dd');
        $mediaSave->year = $year;
        $mediaSave->season = $season;
        $mediaSave->series = $series;
        $mediaSave->image_view = $image_view;
        $mediaSave->views = $view;
        $mediaSave->post_name = $location;
        if($mediaSave->save()){
            $response = 'succes';
            $imageId = $mediaSave->id;
            $image_name = $mediaSave->file_name;
            return response()->json(compact('response','originalImageUrl','thumbImageUrl','imageId','image_name'));        
        }else{
            $response = 'error';
            return response()->json(compact('response','originalImageUrl','thumbImageUrl'));        
        }
    }

    public function imageDetail(Request $request, $id = null)
    {
        $user = Auth::user();
        $mediaInfo = $user->userMedia->where('id',$id)->first();   
          
         if($mediaInfo){
            $status = "true";
            return response()->json(compact('status','mediaInfo'));
         }else {
            $msg = "No data found";
            $status = "false";
            return response()->json(compact('status','msg'));
         }
        
    }

    public function imageDelete(Request $request, $id = null)
    {
       $user = Auth::user(); 
        $mediaInfo = $user->userMedia->where('id',$id)->first();  
        if($mediaInfo){
            if($mediaInfo->delete()){
                $msg = "Image has deleted.";
                $status = "true";
                return response()->json(compact('status','msg'));
            }
        }else{
                $msg = "You have not permission to delete this record.";
                $status = "false";
                return response()->json(compact('status','msg'));
        }

    }
}
