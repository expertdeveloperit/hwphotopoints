<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Series;
use App\SeriesPosts;
use Session;
use Validator;
use Redirect;
use Input;
class AdminSeriesController extends Controller
{   
    // all series list
    public function index(){
    	$series = Series::all();
    	return view('admin.series.series',['series'=>$series]);
    }

    public function editParent(Request $request , $id = null)
    {
        if($id){
            $editseries = Series::where("id",'=',$id)->first();
            
            return view('admin.series.parentseries.createupdate',['editseries'=>$editseries]);
        }
    }

    public function updateParent(Request $request, $id = null)
    {
        $data = $request->all();
        if($id){

            $updateseries = Series::where("id",'=',$id)->first();
            $updateseries->start_year = $data['year'];
            $updateseries->save();
            Session::flash('message', 'Series data has been updated!');
            return redirect()->route('editMainSeries',$id);
        }
    }


    //Specific Series List like P series, L series
    public function series(Request $request, $seriesName = null){
        if($seriesName){
            session(['seriesName' => $seriesName]);
            $seriesData = Series::where("name",'=',$seriesName)->first();
            if($seriesData){
               $data  = SeriesPosts::where('series_id','=',$seriesData['id'])->get();
            }
            
    		return view('admin.series.specificseries',['data'=>$data,'seriesName'=>$seriesName]);
    	}
    }

    public function addNew(Request $request, $seriesName = null){
        if(!empty($seriesName)){            
            return view('admin.series.createupdate',['seriesName'=>$seriesName]);
        }
        return redirect()->route('specificSeries',$seriesName);
        

    }
    

    // Create new series post 
    public function create(Request $request,$seriesName = null){
        $data = $request->all();

        $rules = array(
            'title' => 'required',
            'year'=>'required | numeric',
        );
        $validator = Validator::make($data, $rules);
        if($validator->passes()){

            $seriesData = Series::where("name",'=',$seriesName)->first();
            if($seriesData){
            	$series = new SeriesPosts;	
                $series->series_id = $seriesData['id'];
            	$series->title = $data['title'];
                $series->year = $data['year'];
                $series->description = $data['ordertype'];
                $series->save();
            }    
        	return redirect()->route('specificSeries',$seriesName);
    	}else{
            Session::flash('error',$validator->messages()->first());
            return Redirect::back()->withInput($request->input());
        }
    }

    // edit the post and render the edit form
    public function edit(Request $request, $id = null){
        if(!empty($id)){
        	$editseries = SeriesPosts::find($id);
        	return view('admin.series.createupdate',['editseries'=>$editseries]);
        }
      	return view('admin.series.createupdate');
    }

    // update the series post data
    public function update(Request $request,$id=null){
    	$data = $request->all();
        $rules = array(
            'title' => 'required',
            'year'=>'required | numeric',
        );
        $validator = Validator::make($data, $rules);
        if($validator->passes()){
        	$series = SeriesPosts::find($id);	
        	$series->title = $data['title'];
        	$series->year = $data['year'];
            $series->description = $data['ordertype'];
        	$series->save();
            
            $editseries = SeriesPosts::find($id);
            Session::flash('message', 'Post data has been updated!'); 
            return redirect()->route('editSeries',$id);
    	}else{
            Session::flash('error',$validator->messages()->first());
            return Redirect::back()->withInput($request->input());
        }
    }

    //delete the series
    public function delete(Request $request, $seriesName = null, $id = null){
        if($id){
            SeriesPosts::destroy($id);            
        }
        Session::flash('message', ucfirst($seriesName).' Post has been deleted!');
        return redirect()->route('specificSeries',$seriesName);
        //return redirect()->route('allSeries');
    }
}	
