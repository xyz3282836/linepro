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

Route::get('/home', 'HomeController@index');



Route::get('addclickfarm', 'IndexController@getAddClickFarm');
Route::post('addclickfarm', 'IndexController@postAddClickFarm');
Route::get('clickfarmlist', 'IndexController@listClickFarm');
Route::get('viewclickfarm/{id}', 'IndexController@getViewClickFarm');
Route::get('getinfo', 'IndexController@getInfo');


Route::get('uppwd', 'HomeController@getUpPwd');
Route::post('uppwd', 'HomeController@postUpPwd');