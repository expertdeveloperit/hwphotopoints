<?php
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Series;
use App\SeriesPosts;
use App\SeriesPostViews;
use Session;
use Validator;
use Redirect;
use Input;
class SeriesViewController extends Controller
{
    // specific series view
    public function index(Request $request, $id = null){
    	$post = SeriesPosts::where('id','=',$id)->first();
    	$views = SeriesPostViews::where('series_list_id','=',$id)->get();	
    	return view('admin.series.view.index',['views'=>$views,'post'=>$post]);
    }
    
    public function delete(Request $request,$postId = null, $id = null)
    {
    	if($id){
            SeriesPostViews::destroy($id);            
        }
        Session::flash('message', 'View has been deleted!');
        return redirect()->route('seriesView',$postId);
    }

    public function create(Request $request, $postId=null )
    {
    	$data = $request->all();
        $rules = array(
            'image_view' => 'required',
            'value'=>'required',
            'pan_view'=>'required',
        );
        $validator = Validator::make($data, $rules);
        if($validator->passes()){

        	$view = new SeriesPostViews;
        	$view->series_list_id = $postId;
        	$view->image_view = $data['image_view'];
        	$view->value = $data['value'];
        	$view->pan_view = $data['pan_view'];
        	$view->description = "";
        	$view->save();
            
            $editview = $view;

            Session::flash('message', 'View has been created!'); 
            $post = SeriesPosts::where('id','=',$postId)->first();
            return redirect()->route('seriesViewEdit',$postId.'/'.$editview['id']);
    	}else{
            Session::flash('error',$validator->messages()->first());
            return Redirect::back()->withInput($request->input());
        }
    }

     // edit the post and render the edit form
    public function edit(Request $request, $postId =null, $id = null){
        if(!empty($id)){
        	$post = SeriesPosts::where('id','=',$postId)->first();
        	$editview = SeriesPostViews::find($id);
        	return view('admin.series.view.createupdate',['editview'=>$editview,'post'=>$post]);
        }
        $post = SeriesPosts::where('id','=',$postId)->first();
      	return view('admin.series.view.createupdate',['post'=>$post]);
    }


    // update the series post data
    public function update(Request $request,$postId = null, $id=null){
    	$data = $request->all();
        $rules = array(
            'image_view' => 'required',
            'value'=>'required'
        );
        $validator = Validator::make($data, $rules);
        if($validator->passes()){

        	$series = SeriesPostViews::find($id);	
        	$series->image_view = $data['image_view'];
        	$series->value = $data['value'];
            if($data['pan_view']){
        	   $series->pan_view = $data['pan_view'];
            }else $series->pan_view ="";
        	$series->save();
            
            $editview = SeriesPostViews::find($id);

            Session::flash('message', 'View data has been updated!'); 
            $post = SeriesPosts::where('id','=',$postId)->first();
            return redirect()->route('seriesViewEdit',$postId.'/'.$id);
    	}else{
            Session::flash('error',$validator->messages()->first());
            return Redirect::back()->withInput($request->input());
        }
    }
}
