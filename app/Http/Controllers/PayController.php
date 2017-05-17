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
use App\QuotaBill;
use App\Recharge;
use App\User;
use App\VpBill;
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
        if ($amount >= config('linepro.vp_exchange')) {
            $user = Auth::user();
            if (!$user->checkInfoIscompleted()) {
                return redirect('upmy');
            }
        }
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

                        //有效期、配额
                        if ($model->amount >= config('linepro.vp_exchange')) {
                            //配额
                            $user->quota = $user->quota + config('linepro.quota');
                            QuotaBill::create([
                                'uid'    => $user->id,
                                'type'   => 1,
                                'in'     => config('linepro.quota'),
                                'quota'  => $user->quota,
                                'taskid' => $model->id
                            ]);
                            //有效期
                            if ($user->validity == null || strtotime($user->validity) < time()) {
                                $validity = date('Y-m-d', strtotime('+ '.(config('linepro.vp_days') + 1).' days')) . ' 00:00:00';
                            } else {
                                $validity = date('Y-m-d H:i:s', strtotime('+ '.config('linepro.vp_days').' days', strtotime($user->validity)));
                            }
                            VpBill::create([
                                'uid'      => $user->id,
                                'rid'      => $model->id,
                                'days'     => config('linepro.vp_days'),
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
                        if (request()->isMethod('get')) {
                            return redirect('recharge')
                                ->with(['status' => '充值成功']);
                        } else {
                            die('success');
                        }
                    } catch (Exception $e) {
                        DB::rollBack();
                        die('fail');
                    }
                } else {
                    return redirect('recharge')
                        ->with(['status' => '此次充值失败']);
                }
            } else {
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

        $money = $amount - $model->amount;

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
                'orderid' => $model->orderid,
                'out'     => $model->amount,
                'amount'  => $money,
                'taskid'  => $model->id
            ]);
            //status
            $model->status = 2;
            $model->save();
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
            case 3:
                return redirect('viewevaluate/' . $taskid);
            default:
                throw new Exception();
        }
    }

}