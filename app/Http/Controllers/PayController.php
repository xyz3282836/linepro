<?php
/**
 * Created by PhpStorm.
 * User: zhou
 * Date: 2017/5/12
 * Time: 上午9:59
 */

namespace App\Http\Controllers;


use App\Bill;
use App\ClickFarm;
use App\Events\CfResults;
use App\Recharge;
use Auth;
use DB;
use Exception;
use Omnipay\Omnipay;
use Validator;

class PayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * get
     * 充值
     */
    public function getRecharge()
    {
        return view('pay.recharge');
    }

    /**
     * 支付宝支付
     */
    public function recharge(){
        $gateway = Omnipay::create('Alipay_AopPage');
        $gateway->setSignType(config('alipay.sign_type')); //RSA/RSA2
        $gateway->setAppId(config('alipay.app_id'));
        $gateway->setPrivateKey(config('alipay.app_private_key'));
        $gateway->setAlipayPublicKey(config('alipay.alipay_public_key'));
        $gateway->setReturnUrl('http://localhost/recharge/result');
//        $gateway->setNotifyUrl('http://localhost/recharge/notify');
        $gateway->setEnvironment('sandbox');

        $request = $gateway->purchase();
        $request->setBizContent([
            'out_trade_no' => get_order_id(),
            'total_amount' => 0.01,
            'subject'      => '会员充值',
            'product_code' => 'FAST_INSTANT_TRADE_PAY',
        ]);

        /**
         * @var AopCompletePurchaseResponse $response
         */
        $response = $request->send();
//        dd($response);
        $redirectUrl = $response->getRedirectUrl();
//        dd($redirectUrl);
        return redirect($redirectUrl);
    }

    public function result(){
        $gateway = Omnipay::create('Alipay_AopPage');
        $gateway->setSignType(config('alipay.sign_type')); //RSA/RSA2
        $gateway->setAppId(config('alipay.app_id'));
        $gateway->setPrivateKey(config('alipay.app_private_key'));
        $gateway->setAlipayPublicKey(config('alipay.alipay_public_key'));
        $gateway->setReturnUrl('http://localhost/recharge/result');
//        $gateway->setNotifyUrl('http://localhost/recharge/notify');
        $gateway->setEnvironment('sandbox');
        $request = $gateway->completePurchase();
        $request->setParams(array_merge($_POST, $_GET)); //Don't use $_REQUEST for may contain $_COOKIE

        /**
         * @var AopCompletePurchaseResponse $response
         */
        try {
            $response = $request->send();

            if($response->isPaid()){
                /**
                 * Payment is successful
                 */
                die('success'); //The notify response should be 'success' only
            }else{
                /**
                 * Payment is not successful
                 */
                die('fail'); //The notify response
            }
        } catch (Exception $e) {
            /**
             * Payment is not successful
             */
            die('fail'); //The notify response
        }
    }

    /**
     * post
     * 充值
     */
    public function postRecharge()
    {
        $pdata     = request()->all();
        $validator = Validator::make($pdata, [
            'name'          => 'required|min:1|max:6',
            'mobile'        => 'required|regex:/^1[345789][0-9]{9}/',
            'orderid'       => 'required|integer',
            'amount'        => 'required|numeric|min:1',
            'recharge_time' => 'required|date_format:Y-m-d H:i',
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->getMessages() as $k => $v) {
                p($k . '=>' . $v[0]);
            }
            die;
        }
        $model                = new Recharge;
        $model->uid           = Auth::user()->id;
        $model->name          = $pdata['name'];
        $model->mobile        = $pdata['mobile'];
        $model->orderid       = $pdata['orderid'];
        $model->amount        = $pdata['amount'];
        $model->recharge_time = $pdata['recharge_time'];
        $model->save();

        return redirect('recharge')->with('status', '充值成功');
    }

    /**
     * list
     * 充值
     */
    public function listRecharge()
    {
        $list = Recharge::where('uid', Auth::user()->id)->orderBy('id', 'desc')->paginate(10);
        return view('pay.list_recharge')->with('tname', '充值记录列表')->with('list', $list);
    }

    /**
     * 充值详情
     * view
     */
    public function getViewRecharge($id)
    {
        $one = Recharge::find($id);
        if ($one->uid != Auth::user()->id) {
            throw new Exception();
        }
        return view('pay.view_recharge')->with('one', $one);
    }

    /**
     * 支付刷单任务
     * @return string
     */
    public function postPay()
    {
        $id    = request('id', 0);
        $table = request('type', '');
        $model = null;
        switch ($table) {
            case 'cf':
                $model = ClickFarm::find($id);
                $type  = 2;
                $table = 'click_farms';
                break;
            default:
                return error(MODEL_NOT_FOUNT);
        }

        if (!$model) {
            return error(MODEL_NOT_FOUNT);
        }
        $user = Auth::user();
        if ($model->uid != $user->id) {
            return error(NO_ACCESS);
        }
        if ($model->status != 1) {
            return error(NO_ACCESS);
        }
        $amount = $user->amount;
        if ($amount < $model->amount) {
            return error(NO_ENOUGH_MONEY);
        }

        $money   = $amount - $model->amount;
        $orderid = get_order_id();

        DB::beginTransaction();
        try {
            //减钱
            $user->update(['amount' => $money]);
            if (DB::table($table)->where('id', $id)->value('status') != 1) {
                throw new Exception();
            }
            //流水账
            Bill::create([
                'uid'     => $user->id,
                'type'    => $type,
                'orderid' => $orderid,
                'out'     => $model->amount,
                'amount'  => $money,
                'taskid'  => $model->id
            ]);
            //orderid,status
            $model->update(['status' => 2, 'orderid' => $orderid]);
            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
            return error(ERROR_IDEMPOTENCE);
        }
        //批量新建任务结果记录
        event(new CfResults($model));
        return success();
    }

    /**
     * 流水账单
     */
    public function listBill()
    {
        $start = request('start');
        $end   = request('end');
        $type  = request('type', 0);

        $table = Bill::where('uid', Auth::user()->id);
        if ($start != null && $end != null) {
            $table->whereBetween('created_at', [$start, $end]);
        }

        if ($type) {
            $table->where('type', $type);
        }
        $list = $table->orderBy('id', 'desc')->paginate(10);
        return view('pay.list_bill')->with('tname', '账单列表')->with('list', $list)->with([
            'start' => $start,
            'end'   => $end,
            'type'  => $type
        ]);
    }

    public function billDesc()
    {
        $type   = request('type');
        $taskid = request('taskid');

        switch ($type) {
            case 1:
                return redirect('viewrecharge/' . $taskid);
            case 2:
                return redirect('viewclickfarm/' . $taskid);
            case 3:
                return redirect('viewevaluate/' . $taskid);
            default:
                throw new Exception();
        }
    }

}