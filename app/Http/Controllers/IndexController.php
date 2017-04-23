<?php

namespace App\Http\Controllers;


class IndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 刷单任务
     * view
     */
    public function getViewClickFarm(){

    }

    /**
     * 刷单任务
     * add:get
     */
    public function getAddClickFarm(){
        return view('index.add_clickfarm');
    }

    /**
     * 刷单任务
     * add:post
     */
    public function postAddClickFarm(){

    }

    /**
     * 运行环境信息
     */
    public function getInfo(){
        phpinfo();
    }
}