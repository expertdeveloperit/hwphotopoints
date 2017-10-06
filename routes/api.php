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
Route::get('resetpassword/key/{key}','Api\UserAuthenticate@validateResetKey');
Route::post('reset/password','Api\UserAuthenticate@resetPassword');
Route::get('pages/title','Api\PagesController@getPagesTitle');
Route::get('page/{id?}','Api\PagesController@index');

Route::group(['middleware' => 'jwt.auth'], function () {
    Route::post('year','Api\SeriesController@getYear');
    Route::post('posts','Api\SeriesController@getLocations');
    Route::post('imagetype','Api\SeriesController@imageType');
    Route::post('values','Api\SeriesController@imageViews');
    Route::get('pseries','Api\SeriesController@pSeriesList');
    Route::post('pseriesdetail/firstview','Api\SeriesController@pSeriesPostsDetailFirstView');
    Route::post('pseriesdetail/secondview','Api\SeriesController@pSeriesPostsDetailSecondView');
    Route::post('pseriesdetail/thirdview','Api\SeriesController@pSeriesPostsDetailThirdView');
    Route::post('seriesdetail','Api\SeriesController@anotherSeriesPostsDetail'); 
    Route::post('uploadbatchdata','Api\SeriesController@uploadBatchData')->middleware('visitor'); 
    Route::post('uploaddata','Api\SeriesController@uploadData')->middleware('visitor'); 
    Route::post('updatemediadata','Api\SeriesController@updateMediaData')->middleware('visitor'); 
    Route::get('imagedetail/{id}','Api\SeriesController@imageDetail'); 
    Route::get('deletemedia/{id}','Api\SeriesController@imageDelete')->middleware('visitor'); 
    
});

