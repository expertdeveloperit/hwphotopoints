<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
     return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');




//admin Panel
//pages
Route::get('/admin/pages','Admin\PagesController@index')->name('allPages');
Route::get('/admin/page/editupdate/{id?}','Admin\PagesController@createOrEdit')->name('createOrEdit');
Route::post('/admin/page/addnew/{id?}','Admin\PagesController@addNeworUpdate')->name('addNeworUpdate');
Route::get('/admin/page/delete/{id?}','Admin\PagesController@delete')->name('deletePage');

//Series
Route::get('/admin/series','Admin\AdminSeriesController@index')->name('allSeries');
Route::get('/admin/series/{seriesname?}','Admin\AdminSeriesController@series')->name('specificSeries');
Route::get('/admin/series/edit/{id?}','Admin\AdminSeriesController@edit')->name('editSeries');
Route::post('/admin/series/update/{id?}','Admin\AdminSeriesController@update')->name('updateSeries');

//create new series
Route::get('/admin/series/new/{seriesName?}','Admin\AdminSeriesController@addNew')->name('addNewSeries');
Route::post('/admin/series/new/{seriesName?}','Admin\AdminSeriesController@create')->name('createNewSeries');
Route::get('/admin/series/delete/{seriesName?}/{id?}','Admin\AdminSeriesController@delete')->name('deleteSeries');


//Series Views
Route::get('/admin/series/views/{id?}','Admin\SeriesViewController@index')->name('seriesView');
Route::post('/admin/series/views/create/{postId?}','Admin\SeriesViewController@create')->name('seriesViewCreate');
Route::get('/admin/series/views/edit/{postId?}/{id?}','Admin\SeriesViewController@edit')->name('seriesViewEdit');
Route::post('/admin/series/views/update/{postId?}/{id?}','Admin\SeriesViewController@update')->name('seriesViewUpdate');
Route::get('/admin/series/views/delete/{postId?}/{id?}','Admin\SeriesViewController@delete')->name('seriesViewDelete');