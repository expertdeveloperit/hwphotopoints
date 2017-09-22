<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MediaInformation;
use App\CronJob;
use App\User;
use Image;
use Session;
use Validator;
use Redirect;
use Input;
use Auth;
use Storage;
use File;

class CronJobController extends Controller
{
    //get cron jobs and read

	public function index()
	{
		$allJobs = CronJob::all();
		if($allJobs){
			foreach ($allJobs as $key => $job) {
				$jobData = $job->detail;
				$jobDetail = unserialize($jobData);

				$folderName = $jobDetail['folderName'];
				$csv = $jobDetail['csv'];

				//read CSV file
				$destinationPath = public_path('/uploads/').$folderName.'/';
				$file = fopen($destinationPath.$csv, 'r');
				$index= 0;
				while (($line = fgetcsv($file)) !== FALSE) {
				  	if($index > 0){
				  		$fileName = $line[0];
				  		$series = $line[1];
				        $year = $line[2];
				        $location = $line[3];

				        $filePath = $destinationPath.$fileName;

				        if(file_exists($filePath)){

						    $ext = pathinfo($filePath, PATHINFO_EXTENSION);

					        if($series != "P" && $series != "p"){
					           $season = "";
					           $image_view = "";
					           $view = "";
					           $imageName = $year.'-'.$series.'-'.$location.'.'.$ext;
					           $originalImageName = $year.'/'.$series.'/'.$imageName;
					           $thumbName = $year.'/'.$series.'/thumbs/'.$imageName;
					        }else{
					           $season = $line[4];
					           $image_view = $line[5];
					           $view = $line[6];
					           $imageName = $year.'-'.$season.'-'.$series.'-'.$location.'-'.$image_view.'-'.$view.'.'.$ext;
					           $originalImageName = $year.'/'.$series.'/'.$season.'/'.$image_view.'/'.$imageName;
					           $thumbName = $year.'/'.$series.'/'.$season.'/'.$image_view.'/thumbs/'.$imageName;
					        }




					        //save to amazon server to original image
					        Storage::disk('s3')->put($originalImageName, file_get_contents($filePath),'public');

					        
					        //thumbnails image create and save
					        $thumb = Image::make($filePath)->resize(225, 150,function($constraint){
					            $constraint->aspectRatio(); //maintain image ratio
					        });

					        $filePathSave = $destinationPath.'thumb-'.$imageName;
					        $thumb->save($filePathSave);

					        Storage::disk('s3')->put($thumbName, file_get_contents($filePathSave),'public');


					        //get path from amazon S3 server

					        $originalImageUrl = Storage::disk('s3')->url($originalImageName);
					        $thumbImageUrl = Storage::disk('s3')->url($thumbName);

					        //save the information
					        $user = Auth::user(); 
					        if($series == "P" && $series == "p"){
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
					            
					        }else{
					            
					        }	
					    }    
					}
				  $index++;
				}
				fclose($file);
				//delete database entry
				
				CronJob::destroy($job->id);

				//delete files
			   	//$this->delete_files($destinationPath);		


			   	//send email to user
			   	$user  = User::find($job->user_id);	    
			   	$to = $user->email;
            	$subject = "HW Photo Points Batch Upload.";
	            
	            $txt = "Your batch upload has successfully updated.";
	            $headers = "From: webmaster@example.com" . "\r\n";

	            mail($to,$subject,$txt,$headers);

			}
		}	
	}


	//delete files
	public function delete_files($target) {
	    if(is_dir($target)){
	        $files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned
	        
	        foreach( $files as $file )
	        {
	            $this->delete_files( $file );      
	        }
	      
	        rmdir( $target );
	    } elseif(is_file($target)) {
	        unlink( $target );  
	    }
	}

}