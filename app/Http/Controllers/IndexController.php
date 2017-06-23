<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Faq;

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

    public function faq(){
        return view('index.faq')->with('list',Faq::getFaqs());
    }

    public function download(){
        return view('index.download')->with('list',Banner::getBanners());
    }
}