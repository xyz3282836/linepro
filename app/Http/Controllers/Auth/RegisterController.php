<?php

namespace App\Http\Controllers\Auth;

use App\Bill;
use App\Events\ESendGold;
use App\Exceptions\MsgException;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use DB;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

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
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => 'required|max:35|unique:users',
            'email'    => 'required|email|max:50|unique:users',
            'password' => 'required|min:6|confirmed',
            'captcha'  => 'required|captcha',
            'mobile'   => 'required|regex:/^1[345789][0-9]{9}/',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        DB::beginTransaction();
        try {
            $user = User::create([
                'name'            => $data['name'],
                'email'           => $data['email'],
                'mobile'          => $data['mobile'],
                'password'        => bcrypt($data['password']),
                'last_login_time' => Carbon::now()
            ]);
            Bill::getGoldBySys(gconfig('registergold'), $user);
            DB::commit();
            return $user;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw new MsgException('注册失败');
        }
    }
}
