<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AdminPages;

class PagesController extends Controller
{
    public function index(Request $request,$id = null)
    {
    	if(!empty($id)){
            $page = AdminPages::find($id);
            $data['title'] = $page['title'];
            $data['description'] = $page['description'];
            return response()->json(compact('data'));
        }	
    }
    public function getPagesTitle(Request $request,$id = null)
    {
    	
            $pages = AdminPages::all();
            foreach ($pages as $key => $page) {
            	$data[] = $page['title'];
            }
            return response()->json(compact('data'));
        	
    }
}
