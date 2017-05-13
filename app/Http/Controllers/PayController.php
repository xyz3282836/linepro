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
use Auth;
use DB;
use Exception;

class PayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
}