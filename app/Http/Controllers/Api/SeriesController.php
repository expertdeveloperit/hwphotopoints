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
use File;
class SeriesController extends Controller
{   
    // get minimum year value
    public function getYear(Request $request)
    {
    	$data = $request->all();
    	$seriesName = $data['series'];
    	$seriesData = Series::select('start_year')->where('name','=',$seriesName)->first();
    	//$years = SeriesPosts::select('year')->where('series_id','=',$seriesData->id)->orderBy('year','Asc')->first();
		 $years = $seriesData; 
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
            $getType = SeriesPostViews::select('image_view')->groupBy('image_view')->get();            
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

            $getValue = SeriesPostViews::where('image_view','=',$image_view)->get();
            
        }
        
        $imageValues = array();
        $index = 0;
        $index2 = 0;
        foreach ($getValue as $key => $value) {
            if($image_view =="PAN"){
                $imageValues[$index] = $value['value']." ".$value['pan_view'];
                $index++;
            }else { 
                $imageValues[$index2] = $value['value'];
                $index2++;
            }
        }
        $values = array_values(array_unique($imageValues));
        return response()->json(compact('values'));          
    }


    //get P series Posts list on 'Photos Point Page'

    public function pSeriesList(Request $request)
    {
        $userId = Auth::user()->id;
        $seriesData = Series::where('name','=','P')->first();
        //$posts = SeriesPosts::select('title')->where('series_id','=',$seriesData->id)->get();
        $posts = MediaInformation::select('post_name')->where('series','=','p')->groupBy('post_name')->orderBy('post_name')->get();
        
        return response()->json(compact('posts'));
    }

    //p series Posts  Detail
    public function pSeriesPostsDetailFirstView(Request $request){
        $data = $request->all();
        $postName = $data['postname'];                    
        $userId = Auth::user()->id;    
        $years = $media = MediaInformation::select('year')->where('series','=','P')->where('post_name','=',$postName)->groupBy('year')->orderBy('year')->get();
        //$media = MediaInformation::where('user_id','=',$userId)->where('series','=','P')->where('post_name','=',$postName)->orderBy('season','DESC')->get();
        //get winter data
        $wviews = MediaInformation::select('views')->where('series','=','P')->where('post_name','=',$postName)->where('season','win')->groupBy('views')->get();
        $winterData = array();
        foreach ($wviews as $key => $value) {
               $wdata = MediaInformation::where('series','=','P')->where('post_name','=',$postName)->where('season','win')->where('views',$value->views)->orderBy('year')->get();     
               $winterData[$key]['view'] =  $value->views;
               $winterData[$key]['data'] = $wdata;
        }
        //summer data
        $sviews = MediaInformation::select('views')->where('series','=','P')->where('post_name','=',$postName)->where('season','sum')->groupBy('views')->get();
        $summerData = array();
        foreach ($sviews as $key => $value) {
               $sdata = MediaInformation::where('user_id','=',$userId)->where('series','=','P')->where('post_name','=',$postName)->where('season','sum')->where('views',$value->views)->orderBy('year')->get();     
               $summerData[$key]['view'] =  $value->views;
               $summerData[$key]['data'] = $sdata;
        }

        //spring data
        $sprviews = MediaInformation::select('views')->where('series','=','P')->where('post_name','=',$postName)->where('season','spr')->groupBy('views')->get();
        $springData = array();
        foreach ($sprviews as $key => $value) {
               $sprdata = MediaInformation::where('series','=','P')->where('post_name','=',$postName)->where('season','spr')->where('views',$value->views)->orderBy('year')->get();     
               $springData[$key]['data'] = $sprdata;
               $springData[$key]['view'] =  $value->views;
        }

        //autumn data
        $aviews = MediaInformation::select('views')->where('series','=','P')->where('post_name','=',$postName)->where('season','aut')->groupBy('views')->get();
        $autumnData = array();
        foreach ($aviews as $key => $value) {
               $adata = MediaInformation::where('series','=','P')->where('post_name','=',$postName)->where('season','aut')->where('views',$value->views)->orderBy('year')->get();     
               $autumnData[$key]['data'] = $adata;
               $autumnData[$key]['view'] =  $value->views;
        }
        
        return response()->json(compact('winterData','summerData','springData','autumnData','years'));
    }


    //P series Second View
    
    public function pSeriesPostsDetailSecondView(Request $request){
        $data = $request->all();
        $postName = $data['postname'];                    
        $userId = Auth::user()->id;    
        $years = $media = MediaInformation::select('year')->where('series','=','P')->where('post_name','=',$postName)->groupBy('year')->orderBy('year')->get();
        //$media = MediaInformation::where('user_id','=',$userId)->where('series','=','P')->where('post_name','=',$postName)->orderBy('season','DESC')->get();
        //get winter data
        $allViews = MediaInformation::select('views')->where('series','=','P')->where('post_name','=',$postName)->groupBy('views')->get();
        $ViewsData = array();
        $information = array();
        foreach ($allViews as $key => $value) {
               $ViewsData[$key]['view'] =  $value->views;
               
               $sudata = MediaInformation::where('series','=','P')->where('post_name','=',$postName)->where('views',$value->views)->where('season','sum')->orderBy('year')->get();     
               if($sudata->count() > 0){
                   $sutotalData['season'] = "SUMMER";
                   $ViewsData[$key]['data'][] = $sutotalData;
                   $sutotalData['info'] = $sudata;
                   $information[] = $sutotalData;
               } 
               $widata = MediaInformation::where('series','=','P')->where('post_name','=',$postName)->where('views',$value->views)->where('season','win')->orderBy('year')->get();     
               if($widata->count() > 0){
                   $wtotalData['season'] = "WINTER";
                   $ViewsData[$key]['data'][] = $wtotalData;
                   $wtotalData['info'] = $widata;
                   $information[] = $wtotalData;
               } 

               $spdata = MediaInformation::where('series','=','P')->where('post_name','=',$postName)->where('views',$value->views)->where('season','spr')->orderBy('year')->get();     
               if($spdata->count() > 0){
                    $stotalData['season'] = "SPRING";
                    $ViewsData[$key]['data'][] = $stotalData;
                    $stotalData['info'] = $spdata;
                    $information[] = $stotalData;
               }


               $audata = MediaInformation::where('series','=','P')->where('post_name','=',$postName)->where('views',$value->views)->where('season','aut')->orderBy('year')->get();     
               if($audata->count() > 0){
                    $atotalData['season'] = "AUTUMN";
                    $ViewsData[$key]['data'][] = $atotalData;
                    $atotalData['info'] = $audata;
                     $information[] = $atotalData;
                } 

        }
          
       
        
        return response()->json(compact('ViewsData','years','information'));
    }

    //P series Third View
    public function pSeriesPostsDetailThirdView(Request $request){
        $data = $request->all();
        $postName = $data['postname'];                    
        $userId = Auth::user()->id;    
        $years  = MediaInformation::select('year')->where('series','=','P')->where('post_name','=',$postName)->groupBy('year')->orderBy('year')->get();
        
        $ViewsData = array();
        $information = array();
               
        $views = MediaInformation::select('views')->where('series','=','P')->where('post_name','=',$postName)->groupBy('views')->get();     
        foreach ($views as $viewkey => $viewvalue) {
            $ViewsData[$viewkey]['name'] = $viewvalue->views;
            $index = 0;
            foreach ($years as $key => $year) {
               $seasonInfo =   MediaInformation::where('series','=','P')->where('post_name','=',$postName)->where('year',$year->year)->where('views',$viewvalue->views)->get();
                if($seasonInfo->count() > 0){
                    $ViewsData[$viewkey]['data'][$index]['data'] =  $seasonInfo;
                    $ViewsData[$viewkey]['data'][$index]['year'] = $year->year;
                    $index++;
                }
            }
        }

        return response()->json(compact('ViewsData','years'));
    }



    //another series detail
    public function anotherSeriesPostsDetail(Request $request){
        $data = $request->all();
        $seriesName = $data['seriesname'];                    
        $userId = Auth::user()->id;    
        //$media = MediaInformation::where('user_id','=',$userId)->where('series','=',$seriesName)->get();
        
        $years = MediaInformation::select('year')->where('series','=',$seriesName)->groupBy('year')->orderBy('year')->get();
        //get winter data
        $views_name = MediaInformation::select('views')->where('series','=',$seriesName)->groupBy('views')->get();
        $seriesData = array();
        foreach ($views_name as $key => $value) {
               $wdata = MediaInformation::select('id','file_location_aws','file_thumb_location_aws','post_name','year','series')->where('series','=',$seriesName)->where('views','=',$value->views)->orderBy('year')->get();     
               $seriesData[$key]['view'] =  $value->views;
               $seriesData[$key]['data'] = $wdata;
        }

        return response()->json(compact('seriesData','years'));
    }    

    //when all form data submited

    public function uploadData(Request $request)
    {
        $data = $request->all();

        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $series = $data['series'];
        $year = $data['year'];
        $location = $data['location'];
        if($series != "P" && $series != "p"){
           $season = "";
           $image_view = "";
           $view = "";
        }else{
           $season = $data['season'];
           $image_view = $data['image_view'];
           $view = $data['view'];
        }


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
        if($series == "P" && $series == "p"){
            //$mediaSave = new MediaInformation;
            MediaInformation::updateOrCreate(['series'=>$series,'year'=>$year,'post_name'=>$location,'season'=>$season,'image_view'=>$image_view,'views'=>$view]);
            $mediaSave->user_id = $user->id;
            $mediaSave->file_name = $imageName;
            $mediaSave->file_location_aws = $originalImageUrl;
            $mediaSave->file_thumb_location_aws = $thumbImageUrl;
            $mediaSave->uploaded_by = $user->name;
            $mediaSave->uploading_date = date('y-m-d');
            $mediaSave->year = $year;
            $mediaSave->season = $season;
            $mediaSave->series = $series;
            $mediaSave->image_view = $image_view;
            $mediaSave->views = $view;
            $mediaSave->post_name = $location;
        }else{
            $mediaSave = MediaInformation::updateOrCreate(['series'=>$series,'year'=>$year,'post_name'=>$location]);
            $mediaSave->user_id = $user->id;
            $mediaSave->file_name = $imageName;
            $mediaSave->file_location_aws = $originalImageUrl;
            $mediaSave->file_thumb_location_aws = $thumbImageUrl;
            $mediaSave->uploaded_by = $user->name;
            $mediaSave->uploading_date = date('y-m-d');
            $mediaSave->season = $season;
            $mediaSave->image_view = $image_view;
            $mediaSave->views = $view;
        }
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


    //update media info


    public function updateMediaData(Request $request)
    {

        $data = $request->all();

        if($request->file('image')){
            $this->validate($request, [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
        }

        $series = $data['series'];
        $year = $data['year'];
        $location = $data['location'];
        $media_ID = $data['media_id'];
        if($series != "P" && $series != "p"){
           $season = "";
           $image_view = "";
           $view = "";
        }else{
           $season = $data['season'];
           $image_view = $data['image_view'];
           $view = $data['view'];
        }


        if($request->file('image')){
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
        }
        //save the information
        $user = Auth::user(); 
        if($series == "P" && $series == "p"){
            $mediaSave = MediaInformation::find($media_ID);
            if($request->file('image')){
                $mediaSave->file_name = $imageName;
                $mediaSave->file_location_aws = $originalImageUrl;
                $mediaSave->file_thumb_location_aws = $thumbImageUrl;
            }
            $mediaSave->uploaded_by = $user->name;
            $mediaSave->uploading_date = date('y-m-d');
            $mediaSave->year = $year;
            $mediaSave->season = $season;
            $mediaSave->series = $series;
            $mediaSave->image_view = $image_view;
            $mediaSave->views = $view;
            $mediaSave->post_name = $location;
        }else{
            $mediaSave = MediaInformation::find($media_ID);
            $mediaSave->user_id = $user->id;
            if($request->file('image')){
                $mediaSave->file_name = $imageName;
                $mediaSave->file_location_aws = $originalImageUrl;
                $mediaSave->file_thumb_location_aws = $thumbImageUrl;
            }
            $mediaSave->uploaded_by = $user->name;
            $mediaSave->uploading_date = date('y-m-d');
            $mediaSave->season = $season;
            $mediaSave->image_view = $image_view;
            $mediaSave->views = $view;
        }
        if($mediaSave->save()){
            $response = 'succes';
            $imageId = $mediaSave->id;
            $originalImageUrl = $mediaSave->file_location_aws;
            $thumbImageUrl = $mediaSave->file_thumb_location_aws;
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
            $url = $mediaInfo->file_location_aws;
            $exifData = array();    
            //$exif = exif_read_data($url, 'IFD0');
            // if($exif===false) { 
            //     $exifmsg = "No exif data found."; $exifstatus="false"; 
            // }else{
            //     $exifstatus="true";
            //     // $exif = exif_read_data($url, 0, true);
            //     // foreach ($exif as $key => $section) {
            //     //     foreach ($section as $name => $val) {
            //     //         //$exifData[] = $key.$name.$val;
            //     //         echo $key."@@".$name."@@".$val;
            //     //     }
            //     // }
            // }    
            
            return response()->json(compact('status','mediaInfo','exifData'));
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


    //upload batch data
    public function uploadBatchData(Request $request)
    {
        $data = $request->all();
        $numbersOfFile =  count($request->file('fileIndex'));

        $csvCount = count($request->file('csv'));

        $allFiles = $request->file('fileIndex');    
        if($numbersOfFile > 0 && $csvCount > 0){
            $destinationPath = public_path('/uploads/').time();
            File::makeDirectory($destinationPath, $mode = 0777, true, true);
            //upload multiple images
            foreach ($allFiles as $file) {
                $name =  $file->getClientOriginalName();
                $file = $file->move($destinationPath, $name);
            }
            //upload CSV
            $csv = $request->file('csv');
            $csvName = $csv->getClientOriginalName();
            $csvFile = $csv->move($destinationPath, $csvName);    
            
            $msg = "Images and CSV file has uploaded.";
            $status = "true";
            return response()->json(compact('status','msg'));    
        }else{
            $msg = "Please upload both csv and image.";
            $status = "false";
            return response()->json(compact('status','msg'));
        }       

    }


}
