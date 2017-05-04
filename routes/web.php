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

Route::get('home', 'HomeController@index');



Route::get('addclickfarm', 'IndexController@getAddClickFarm');
Route::post('addclickfarm', 'IndexController@postAddClickFarm');
Route::get('clickfarmlist', 'IndexController@listClickFarm');
Route::get('viewclickfarm/{id}', 'IndexController@getViewClickFarm');
Route::get('getinfo', 'IndexController@getInfo');

Route::get('addevaluate', 'IndexController@getAddEvaluate');
Route::post('addevaluate', 'IndexController@postAddEvaluate');
Route::get('evaluatelist', 'IndexController@listEvaluate');
Route::get('viewevaluate/{id}', 'IndexController@getViewEvaluate');

Route::get('uppwd', 'HomeController@getUpPwd');
Route::get('upmy', 'HomeController@getUpMy');
Route::post('uppwd', 'HomeController@postUpPwd');
Route::post('upmy', 'HomeController@postUpMy');

Route::get('recharge', 'IndexController@getRecharge');
Route::get('viewrecharge/{id}', 'IndexController@getViewRecharge');
Route::post('recharge', 'IndexController@postRecharge');
Route::get('rechargelist', 'IndexController@listRecharge');

Route::post('cancle', 'IndexController@postCancle');
Route::post('pay', 'IndexController@postPay');

Route::any('billlist', 'IndexController@listBill');

Route::get('getbilldesc', 'IndexController@billDesc');

