<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('user/login','Api\UserAuthenticate@authenticate');
Route::post('forgetpassword','Api\UserAuthenticate@forgetPassword');

Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('page/{id?}','Api\PagesController@index');
    Route::post('year','Api\SeriesController@getYear');
    Route::post('posts','Api\SeriesController@getLocations');
    Route::post('imagetype','Api\SeriesController@imageType');
    Route::post('values','Api\SeriesController@imageViews');
    Route::get('pseries','Api\SeriesController@pSeriesList');
    Route::post('pseriesdetail/firstview','Api\SeriesController@pSeriesPostsDetailFirstView');
    Route::post('pseriesdetail/secondview','Api\SeriesController@pSeriesPostsDetailSecondView');
    Route::post('pseriesdetail/thirdview','Api\SeriesController@pSeriesPostsDetailThirdView');
    Route::post('seriesdetail','Api\SeriesController@anotherSeriesPostsDetail'); 
    Route::post('uploaddata','Api\SeriesController@uploadData'); 
    Route::get('imagedetail/{id}','Api\SeriesController@imageDetail'); 
    Route::get('deletemedia/{id}','Api\SeriesController@imageDelete'); 
    
});

