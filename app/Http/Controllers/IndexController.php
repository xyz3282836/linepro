<?php

namespace App\Http\Controllers;


use Gregwar\Captcha\CaptchaBuilder;
use Session;

class IndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * 运行环境信息
     */
    public function getInfo()
    {
        phpinfo();
    }

    public function captcha()
    {
        return captcha_img('flat');
    }
}