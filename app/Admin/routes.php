<?php

use Illuminate\Routing\Router;

Admin::registerHelpersRoutes();

Route::group([
    'prefix'        => config('admin.prefix'),
    'namespace'     => Admin::controllerNamespace(),
    'middleware'    => ['web', 'admin'],
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    $router->resource('config','ConfigController');

    $router->resource('faq','FaqController');

    $router->resource('banner','BannerController');

    $router->resource('user','UserController');

    $router->resource('order','OrderController');

    $router->resource('rate','RateController');

    //上传图片(富文本编辑器需要使用)
    $router->post('upload', 'FileController@upload');

});
