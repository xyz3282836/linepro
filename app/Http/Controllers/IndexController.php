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
     * 运行环境信息
     */
    public function getInfo()
    {
        phpinfo();
    }
}