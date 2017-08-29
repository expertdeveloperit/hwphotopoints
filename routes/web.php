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
Route::get('/admin/pages','Admin\PagesController@index');

Route::get('/admin/pages/create','Admin\PagesController@create');

Route::post('/admin/pages/addnew','Admin\PagesController@addNew')->name('addnew');