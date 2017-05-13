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


//cf
Route::get('addTask', 'CfController@getAddClickFarm');
Route::post('addclickfarm', 'CfController@postAddClickFarm');
Route::get('card', 'CfController@listCardClickFarm');
Route::get('itemlist', 'CfController@listTradeClickFarm');
Route::post('canclecf', 'CfController@postCancle');
Route::any('viewclickfarm/{id}', 'CfController@listCfResult');

//获取环境信息
Route::get('getinfo', 'IndexController@getInfo');


//my
Route::get('uppwd', 'HomeController@getUpPwd');
Route::get('upmy', 'HomeController@getUpMy');
Route::post('uppwd', 'HomeController@postUpPwd');
Route::post('upmy', 'HomeController@postUpMy');

//recharge
Route::get('recharge', 'IndexController@getRecharge');
Route::get('viewrecharge/{id}', 'IndexController@getViewRecharge');
Route::post('recharge', 'IndexController@postRecharge');
Route::get('rechargelist', 'IndexController@listRecharge');

//pay
Route::post('pay', 'PayController@postPay');

//资金流水
Route::any('billlist', 'IndexController@listBill');
Route::get('getbilldesc', 'IndexController@billDesc');

//upfile
Route::post('upload', 'HomeController@upload');

