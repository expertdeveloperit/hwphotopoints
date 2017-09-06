<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use App\Series;
use App\SeriesPosts;
use App\SeriesPostViews;
use Session;
use Validator;
use Redirect;
use Input;
use Auth;
class SeriesController extends Controller
{
    public function getYear(Request $request)
    {
    	$data = $request->all();
    	$seriesName = $data['series'];
    	$seriesData = Series::where('name','=',$seriesName)->first();
    	$years = SeriesPosts::select('year')->where('series_id','=',$seriesData->id)->orderBy('year','Asc')->first();
		
		return response()->json(compact('years'));
    }

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

    public function imageType(Request $request)
    {
    	$data = $request->all();
    	$year = $data['year'];
    	$location = $data['location'];

    	$postId = SeriesPosts::select('id')->where('title','=',$location)->where('year','=',$year)->first();
    	//return $postId;
    	$getType = SeriesPostViews::where('series_list_id','=',$postId->id)->groupBy('image_view')->get();
    	return $getType;

    		
    }
}
