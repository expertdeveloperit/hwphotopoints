<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Series;
use App\SeriesPosts;
class AdminSeriesController extends Controller
{
    public function index(){
    	$series = Series::all();
    	return view('admin.series.series',['series'=>$series]);
    }

    public function series(Request $request, $seriesName = null){
    	if($seriesName){
    		$data  = SeriesPosts::where('id','=',1)->get();	
    		return view('admin.series.pseries',['data'=>$data]);
    	}
    }

    public function create(Request $request){
    	$data = $request->all();
    	$series = new Series;	
    	$series->name = $data['name'];
    	$series->description = $data['description'];
    	$series->save();
    	return redirect()->route('allSeries');
    	
    }

    public function edit(Request $request, $id = null){
        if(!empty($id)){
        	$editseries = SeriesPosts::find($id);
        	return view('admin.series.createupdate',['editseries'=>$editseries]);
        }
      	return view('admin.series.createupdate');
    }

    public function update(Request $request,$id=null){
    	$data = $request->all();
    	$series = SeriesPosts::find($id);	
    	$series->title = $data['title'];
    	$series->year = $data['year'];
    	$series->save();
    	return redirect()->route('specificSeries');
    	
    }

    public function delete(Request $request, $id = null){
        if($id){
            Series::destroy($id);            
        }
        return redirect()->route('allSeries');
    }
}	
