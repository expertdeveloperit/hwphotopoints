<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use App\Series;
use App\SeriesPosts;
use App\SeriesPostViews;
use App\MediaInformation;
use Session;
use Validator;
use Redirect;
use Input;
use Auth;
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


}
