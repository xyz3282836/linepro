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
     * view
     */
    public function getViewClickFarm(){

    }

    /**
     * add:get
     */
    public function getAddClickFarm(){
        return view('index.add_clickfarm');
    }

    /**
     * add:post
     */
    public function postAddClickFarm(){

    }

    public function getInfo(){
        p(get_order_id());
        phpinfo();
    }
}