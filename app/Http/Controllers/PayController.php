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
use App\Exceptions\MsgException;
use App\Recharge;
use App\User;
use App\VipBill;
use Auth;
use DB;
use Exception;

class PayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'result']);
    }

    /**
     * get
     * 充值
     */
    public function getRecharge()
    {
        //充值时资料要完善
        return view('pay.recharge');
    }

    /**
     * post
     * 支付宝支付
     */
    public function recharge()
    {
        $this->validate(request(), [
            'amount' => 'required|numeric|min:1',
        ]);
        $amount = request('amount');
        $orderid        = get_order_id();
        $model          = new Recharge;
        $model->uid     = Auth::user()->id;
        $model->amount  = $amount;
        $model->orderid = $orderid;
        $model->type    = 1;
        $model->save();

        $gateway = get_alipay();
        $request = $gateway->purchase();
        $request->setBizContent([
            'out_trade_no' => $orderid,
            'total_amount' => $amount,
            'subject'      => '充值',
            'product_code' => 'FAST_INSTANT_TRADE_PAY',
        ]);

        $response    = $request->send();
        $redirectUrl = $response->getRedirectUrl();
        return redirect($redirectUrl);
    }

    /**
     * get/post
     * 充值回调
     */
    public function result()
    {
        $gateway = get_alipay();
        $request = $gateway->completePurchase();
        $request->setParams(array_merge($_POST, $_GET));
        $flag = false;
        try {
            $response = $request->send();
            if ($response->isPaid()) {
                $data           = $response->getData();
                $orderid        = $data['out_trade_no'];
                $alipay_orderid = $data['trade_no'];
                $model          = Recharge::where('orderid', $orderid)->first();
                if ($model && $model->status == 0) {
                    // 改变状态 加钱 流水账 判断会员是否要加有效期、配额
                    DB::beginTransaction();
                    try {
                        // 改变状态
                        $model->orderid        = $orderid;
                        $model->alipay_orderid = $alipay_orderid;
                        $model->status         = 1;
                        $model->save();

                        // 账号充钱
                        $user         = User::find($model->uid);
                        $user->amount = $user->amount + $model->amount;

                        //有效期
                        if ($model->amount >= config('linepro.vp_exchange')) {
                            //有效期
                            $adddays = floor($model->amount / config('linepro.vp_exchange')) * config('linepro.vp_days');
                            if ($user->validity == null || strtotime($user->validity) < time()) {
                                $validity = date('Y-m-d', strtotime('+ ' . ($adddays + 1) . ' days')) . ' 00:00:00';
                            } else {
                                $validity = date('Y-m-d H:i:s', strtotime('+ ' . $adddays . ' days', strtotime($user->validity)));
                            }
                            VipBill::create([
                                'uid'      => $user->id,
                                'rid'      => $model->id,
                                'days'     => $adddays,
                                'validity' => $validity,
                            ]);
                            $user->level    = 2;
                            $user->validity = $validity;
                        }

                        $user->save();
                        //流水账
                        Bill::create([
                            'uid'     => $user->id,
                            'type'    => 1,
                            'orderid' => $model->orderid,
                            'in'      => $model->amount,
                            'amount'  => $user->amount,
                            'taskid'  => $model->id
                        ]);

                        DB::commit();
                        $flag = true;
                    } catch (Exception $e) {
                        DB::rollBack();
                        $flag = false;
                    }
                } elseif ($model && $model->status == 1) {
                    $flag = true;
                } else {
                    $flag = false;
                }
            } else {
                $flag = false;
            }
        } catch (Exception $e) {
            $flag = false;
        } finally {
            if ($flag) {
                $text = '充值成功';
                $json = 'success';
            } else {
                $text = '此次充值失败';
                $json = 'fail';
            }
            if (request()->isMethod('get')) {
                return redirect('recharge')
                    ->with(['status' => $text]);
            } else {
                die($json);
            }
        }
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
            throw new MsgException();
        }
        return view('pay.view_recharge')->with('one', $one);
    }

    /**
     * 支付刷单任务
     * @return string
     */
    public function postPay()
    {
        $ids   = request('id');
        $table = request('type', '');
        $user = Auth::user();
        switch ($table) {
            case 'cf':
                $list = ClickFarm::where('uid',$user->id)->where('status',1)->whereIn('id',$ids)->get();
                $type  = 2;
                $table = 'click_farms';
                break;
            default:
                return error(MODEL_NOT_FOUNT);
        }
        if (!$list) {
            return error(MODEL_NOT_FOUNT);
        }
        //计算总金币 总价格
        $allgolds = 0;
        $allprice = 0.00;
        foreach ($list as $one) {
            $allgolds += $one->golds;
            $allprice += $one->amount;
        }
        if($user->golds < $allgolds){
            return error(NO_ENOUGH_GOLD);
        }
        if($one->amount > 0){
            //扣余额
            if($allprice > $one->amount){
                //需要锁下单
                $allprice = $allprice-$one->amount;

            }else{
                //余额足够支付

            }
        }

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

    /**
     * 流水账单详情
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws Exception
     */
    public function billDesc()
    {
        $type   = request('type');
        $taskid = request('taskid');

        switch ($type) {
            case 1:
                return redirect('viewrecharge/' . $taskid);
            case 2:
                return redirect('viewclickfarm/' . $taskid);
            default:
                throw new MsgException();
        }
    }

}