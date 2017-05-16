<?php

namespace App\Http\Controllers;

use App\Events\Vp;
use App\VpBill;
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
        event(new Vp(Auth::user()));
        return view('home');
    }

    public function getUpPwd()
    {
        return view('auth.passwords.up');
    }

    public function getUpMy()
    {
        return view('my.desc');
    }

    public function postUpPwd(Request $request)
    {
        if (!Hash::check($request->input('opassword'), Auth::user()->getAuthPassword())) {
            return redirect('uppwd')
                ->withErrors(['opassword' => '密码错误']);
        }
        $this->validate($request, [
            'password' => 'required|confirmed|min:6',
        ]);
        DB::table('users')->where('id', Auth::user()->id)->update(['password' => bcrypt($request->input('password'))]);
        return redirect('uppwd')
            ->with(['status' => '密码修改成功']);
    }

    public function postUpMy()
    {
        $this->validate(request(), [
            'mobile'          => 'required|regex:/^1[345789][0-9]{9}$/',
            'addr'            => 'required|min:5|max:50',
            'shipping_addr'   => 'required|min:5|max:50',
            'real_name'       => 'required|min:2|max:6',
            'management_type' => 'required|integer',
            'idcardpic'       => 'required',
            'idcardno'        => ['required', 'regex:/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/'],
        ]);
        $pdata['mobile']          = request('mobile');
        $pdata['addr']            = request('addr');
        $pdata['management_type'] = request('management_type');
        $pdata['shipping_addr']   = request('shipping_addr');
        $pdata['real_name']       = request('real_name');
        $pdata['idcardpic']       = request('idcardpic');
        $pdata['idcardno']        = request('idcardno');
        $user                     = Auth::getUser();
        $user->update($pdata);
        return redirect('upmy')
            ->with(['status' => '资料修改成功']);
    }

    public function upload(Request $request)
    {
        switch (request('type')) {
            case 'idcard':
                $file     = $request->file('upimg');
                $ext      = $file->getClientOriginalExtension();
                $filename = time() . rand(100000, 999999) . '.' . $ext;
                $file->move('../public/upfile/idcard/', $filename);
                $fullname = '/upfile/idcard/' . $filename;
                break;
            case 'video':
                $file     = $request->file('upvideo');
                $ext      = $file->getClientOriginalExtension();
                $filename = time() . rand(100000, 999999) . '.' . $ext;
                $file->move('../public/upfile/video/', $filename);
                $fullname = '/upfile/video/' . $filename;
                break;
        }

        return success($fullname);
    }

    /**
     * 会员有效期记录
     */
    public function listVp(){
        if(Auth::user()->level == 2){
            $tname = '会有有效期截止 <span class="color-red">'.substr(Auth::user()->validity,0,10).'</span>';
        }else{
            $tname = '会员有效期记录';
        }
        $list = VpBill::where('uid', Auth::user()->id)->orderBy('id', 'desc')->paginate(10);
        return view('my.list_vp')->with('tname', $tname)->with('list', $list);
    }
}
