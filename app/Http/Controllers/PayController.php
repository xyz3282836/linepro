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
use App\Exceptions\MsgException;
use App\Order;
use App\Recharge;
use Auth;
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
        $one    = Order::rechargeGolds($amount);

        $gateway = get_alipay();
        $request = $gateway->purchase();
        $request->setBizContent([
            'out_trade_no' => $one->orderid,
            'total_amount' => $amount,
            'subject'      => '充值金币',
            'product_code' => 'FAST_INSTANT_TRADE_PAY',
        ]);

        $response    = $request->send();
        $redirectUrl = $response->getRedirectUrl();
        return redirect($redirectUrl);
    }

    /**
     * 删除订单
     */
    public function delOrder()
    {
        $id  = request('id', 0);
        $one = Order::find($id);
        if (!$one) {
            return error(MODEL_NOT_FOUNT);
        }
        if ($one->uid != Auth::user()->id) {
            return error(NO_ACCESS);
        }
        if ($one->status != Order::STATUS_UNPAID) {
            return error(NO_ACCESS);
        }
        Order::delOrder($one);
        return success();
    }

    /**
     * 支付订单，跳转
     */
    public function jumpAlipay()
    {
        $id  = request('id', 0);
        $one = Order::find($id);
        if (!$one) {
            return error(MODEL_NOT_FOUNT);
        }
        if ($one->uid != Auth::user()->id) {
            return error(NO_ACCESS);
        }
        if ($one->status != 1) {
            return error('已支付');
        }
        switch ($one->type) {
            case Order::TYPE_RECHARGE:
                $subject = '充值金币';
                $amount  = round($one->golds / $one->rate, 2);
                break;
            case Order::TYPE_CONSUME:
                $subject = '代购支付';
                $amount  = round($one->price - $one->balance, 2);
                break;
        }
        $gateway = get_alipay();
        $request = $gateway->purchase();
        $request->setBizContent([
            'out_trade_no' => $one->orderid,
            'total_amount' => (string)$amount,
            'subject'      => $subject,
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
        $flag    = false;
        $typeurl = Order::TYPE_RECHARGE;
        try {
            $response = $request->send();
            if ($response->isPaid()) {
                $data           = $response->getData();
                $orderid        = $data['out_trade_no'];
                $alipay_orderid = $data['trade_no'];
                $model          = Order::where('orderid', $orderid)->first();
                if ($model->status == Order::STATUS_UNPAID) {
                    switch ($model->type) {
                        case Order::TYPE_RECHARGE:
                            Order::payRechargeGolds($model, $alipay_orderid);
                            break;
                        case Order::TYPE_CONSUME:
                            $typeurl = Order::TYPE_CONSUME;
                            Order::payOrder($model, $alipay_orderid);
                            break;
                    }
                    $flag = true;
                } elseif ($model->status == Order::STATUS_PAID) {
                    $flag = true;
                }
            } else {
                $flag = false;
            }
        } catch (Exception $e) {
            $flag = false;
        } finally {
            if ($flag) {
                $text = '支付成功';
                $json = 'success';
            } else {
                $text = '此次支付失败';
                $json = 'fail';
            }
            if (request()->isMethod('get')) {
                if ($typeurl == Order::TYPE_RECHARGE) {
                    return redirect('orderlist');
                } else {
                    return redirect('rechargelist');
                }
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
        $list = Order::where('uid', Auth::user()->id)->where('type', Order::TYPE_RECHARGE)->orderBy('id', 'desc')->paginate(10);
        return view('pay.list_recharge')->with('tname', '充值金币记录列表')->with('list', $list);
    }

    /**
     * 支付刷单任务
     * @return string
     */
    public function postPay()
    {
        $ids  = request('id');
        $user = Auth::user();
        $list = ClickFarm::where('uid', $user->id)->where('status', 1)->whereIn('id', $ids)->get();
        if (count($list) == 0) {
            return error(MODEL_NOT_FOUNT);
        }
        //计算总金币 总价格
        $golds = 0;
        $price = 0.00;
        foreach ($list as $one) {
            $golds += $one->golds;
            $price += $one->amount;
        }
        //金币不够
        if (($user->golds - $user->lock_golds) < $golds) {
            return error(NO_ENOUGH_GOLDS);
        }
        $balance = $user->balance - $user->lock_balance;
        if ($price > $balance) {
            //余额+充值 跳转 不生成bill
            $one          = Order::consumeByPartRecharge($price, $golds, $balance, $list);
            return success(['type'=>'p','id'=>$one->id]);
        }
        //余额 生成bill
        $one = Order::consumeByBalance($price, $golds, $list);
        return success(['type'=>'b','id'=>$one->id]);
    }

    /**
     * 流水账单
     */
    public function listBill()
    {
        $start = request('start');
        $end   = request('end');
        $type  = request('type', -1);

        $table = Bill::where('uid', Auth::user()->id);
        if ($start != null && $end != null) {
            $table->whereBetween('created_at', [$start, $end]);
        }

        if ($type >= 0) {
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