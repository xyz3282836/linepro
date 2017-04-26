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

    public function postUpPwd(Request $request){
        if(!Hash::check($request->input('opassword'),Auth::getUser()->getAuthPassword())){
            return redirect('uppwd')
                ->withErrors(['opassword'=>'密码错误']);
        }
        $this->validate($request, $this->rules());
        DB::table('users')->where('id',Auth::user()->id)->update(['password'=>bcrypt($request->input('password'))]);
        return redirect('uppwd')
            ->with(['status'=>'密码修改成功']);
    }

    protected function rules()
    {
        return [
            'password' => 'required|confirmed|min:6',
        ];
    }
}
