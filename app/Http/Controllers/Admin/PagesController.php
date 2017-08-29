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

    public function create(){
      	return view('admin.pages.new');
    }

    public function addNew(Request $request){
    	$data = $request->all();
    	$newPage = new AdminPages;
    	$newPage->title = $data['title'];
    	$newPage->description = $data['editor'];
    	$newPage->save();
    	return view('admin.pages.new');
    }
}
