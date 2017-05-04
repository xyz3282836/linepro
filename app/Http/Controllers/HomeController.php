<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use DB;
use Hash;
use Illuminate\Http\Request;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function getUpPwd(){
        return view('auth.passwords.up');
    }

    public function getUpMy(){
        return view('my.desc');
    }

    public function postUpPwd(Request $request){
        if(!Hash::check($request->input('opassword'),Auth::user()->getAuthPassword())){
            return redirect('uppwd')
                ->withErrors(['opassword'=>'密码错误']);
        }
        $this->validate($request, [
            'password' => 'required|confirmed|min:6',
        ]);
        DB::table('users')->where('id',Auth::user()->id)->update(['password'=>bcrypt($request->input('password'))]);
        return redirect('uppwd')
            ->with(['status'=>'密码修改成功']);
    }

    public function postUpMy(Request $request){
        $this->validate($request, [
            'mobile'=>'required|regex:/^1[345789][0-9]{9}/',
            'addr' => 'required|min:5|max:50',
            'management_type' => 'required|integer',
        ]);
        $pdata = [];
        $pdata['mobile'] = request('mobile');
        $pdata['addr'] = request('addr');
        $pdata['management_type'] = request('management_type');
        DB::table('users')->where('id',Auth::user()->id)->update($pdata);
        return redirect('upmy')
            ->with(['status'=>'资料修改成功']);
    }
}
