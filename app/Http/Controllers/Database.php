<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\MediaInformation;
use App\SeriesPosts;
use App\SeriesPostViews;
use App\Series;
use Illuminate\Support\Facades\DB;
class Database extends Controller
{	
	// series controller
    public function index(){
    	// $users = DB::table('series_L')->where('series', 'L')->get();
    	// echo "<pre>";
    	// print_r($users);
    	// foreach ($users as $key => $value) {
    	// 	$postname = $value->post_name;
    	// 	$year = $value->year;
    	// 	$seriesPosts = new SeriesPosts;
    	// 	$seriesPosts->series_id = 3;
    	// 	$seriesPosts->title = $postname;
    	// 	$seriesPosts->year = $year;
    	// 	$seriesPosts->save();
    	// }



    	// $users = DB::table('views')->get();
    	// echo "<pre>";
    	// foreach ($users as $key => $value) {
    	// 	print_r($value);
    	// 	$postname = $value->post_name;
    	// 	$PostData =  SeriesPosts::where('title',$postname)->first();
    	// 	$id = $PostData->id;
    	// 	$viewData = new SeriesPostViews;
    	// 	$viewData->series_list_id = $id;
    	// 	$viewData->image_view = $value->image_view;
    	// 	$viewData->value = $value->value;
    	// 	$viewData->pan_view = $value->pan_view;
    	// 	$viewData->save();
    	// }


    	// $users = DB::table('upload_information')->get();
    	// echo "<pre>";
    	// foreach ($users as $key => $value) {
    	// 	//print_r($value);
    	// 	$viewData = new MediaInformation;
    	// 	$viewData->user_id = 2;
    	// 	$viewData->file_name = $value->file_name;
    	// 	$viewData->file_location_aws = $value->file_location_aws;
    	// 	$viewData->file_thumb_location_aws = $value->file_thumb_location_aws;
    	// 	$viewData->uploaded_by = $value->uploaded_by;
    	// 	$viewData->uploading_date = $value->uploading_date;
    	// 	$viewData->year = $value->year;
    	// 	$viewData->season = $value->season;
    	// 	$viewData->series = $value->series;
    	// 	$viewData->image_view = $value->image_view;
    	// 	$viewData->views = $value->views;
    	// 	$viewData->post_name = $value->post_name;
    	// 	$viewData->save();
    	// }

    }
}
