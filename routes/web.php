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


Route::post('/admin/series/new','Admin\AdminSeriesController@create')->name('createNewSeries');
Route::get('/admin/series/edit/{id?}','Admin\AdminSeriesController@edit')->name('editSeries');
Route::post('/admin/series/update/{id?}','Admin\AdminSeriesController@update')->name('updateSeries');
Route::get('/admin/series/delete/{id?}','Admin\AdminSeriesController@delete')->name('deleteSeries');