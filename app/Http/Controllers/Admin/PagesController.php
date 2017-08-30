<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AdminPages;
class PagesController extends Controller
{
    public function index(){
    	$allPages = AdminPages::all();
    	return view('admin.pages.home',['allPages' => $allPages]);

    }

    public function createOrEdit(Request $request, $id = null){
        if(!empty($id)){
            $page = AdminPages::find($id);
            return view('admin.pages.update',['page'=>$page]);    
        }
      	return view('admin.pages.new');
    }

    public function addNeworUpdate(Request $request,$id = null){

        $data = $request->all();
        if($id !=""){
            $updatePage = AdminPages::find($id);    
            $updatePage->title = $data['title'];
            $updatePage->description = $data['editor'];
            $updatePage->save();
            
            return redirect('/admin/page/editupdate/'.$id);
            
        }
    	$newPage = new AdminPages;
    	$newPage->title = $data['title'];
    	$newPage->description = $data['editor'];
    	$newPage->save();
    	return redirect('/admin/page/editupdate/'.$newPage['id']);
    }

    public function delete(Request $request, $id = null){
        if($id){
            AdminPages::destroy($id);
            return redirect('/admin/pages');    
        }
    }
}
