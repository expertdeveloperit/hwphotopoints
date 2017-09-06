<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AdminPages;
use JWTAuth;
use App\Series;
use App\SeriesPosts;
use Session;
use Validator;
use Redirect;
use Input;
use Auth;
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
}
