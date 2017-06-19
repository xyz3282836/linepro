<?php
/**
 * Created by PhpStorm.
 * User: zhou
 * Date: 2017/4/28
 * Time: 上午9:58
 */

namespace App;

use App\Events\CfResults;
use App\Exceptions\MsgException;
use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUS_DEL          = 0;//已删除
    const STATUS_UNPAID       = 1;//待付款
    const STATUS_PAID         = 2;//已付款
    const STATUS_UNDERWAY     = 3;//进行中
    const STATUS_FULL_SUCCESS = 4;//全部完成
    const STATUS_FULL_FAILURE = 5;//全部失败
    const STATUS_PART_FAILURE = 6;//部分失败

    const TYPE_RECHARGE = 1;//充值
    const TYPE_CONSUME  = 2;//消费
    const TYPE_REFUND   = 3;//退款

    const PTYPE_ALIPAY = 1;
    protected $fillable = [
        'uid', 'type', 'payment_type', 'orderid', 'alipay_orderid', 'balance', 'price', 'golds', 'rate', 'status'
    ];
    protected $appends = ['type_text', 'status_text', 'payment_type_text'];

    /**
     * 充值金币
     * @param $amount
     * @param $user
     * @return mixed
     * @throws MsgException
     */
    public static function rechargeGolds($amount)
    {
        $user = Auth::user();
        DB::beginTransaction();
        try {
            $golds = $amount * gconfig('rmbtogold');
            $one   = self::create([
                'uid'          => $user->id,
                'type'         => self::TYPE_RECHARGE,
                'payment_type' => self::PTYPE_ALIPAY,
                'orderid'      => get_order_id(),
                'golds'        => $golds,
                'rate'         => gconfig('rmbtogold'),
                'status'       => self::STATUS_UNPAID
            ]);
            DB::commit();
            return $one;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw new MsgException();
        }
    }

    /**
     * 完成充值金币
     * @param Order $one
     * @param $alipay_orderid
     * @throws MsgException
     */
    public static function payRechargeGolds(self $one, $alipay_orderid)
    {
        $user = User::find($one->uid);
        DB::beginTransaction();
        try {
            $one->status         = self::STATUS_PAID;
            $one->alipay_orderid = $alipay_orderid;
            $one->save();
            $user->golds = $user->golds + $one->golds;
            $amount      = $one->golds / $one->rate;
            //有效期
            if ($amount >= gconfig('cost.vip')) {
                //有效期
                $adddays = floor($amount / gconfig('cost.vip')) * gconfig('vip.days');
                if ($user->validity == null || strtotime($user->validity) < time()) {
                    $validity = date('Y-m-d', strtotime('+ ' . ($adddays + 1) . ' days')) . ' 00:00:00';
                } else {
                    $validity = date('Y-m-d H:i:s', strtotime('+ ' . $adddays . ' days', strtotime($user->validity)));
                }
                VipBill::create([
                    'uid'      => $user->id,
                    'oid'      => $one->id,
                    'days'     => $adddays,
                    'validity' => $validity,
                ]);
                $user->level    = 2;
                $user->validity = $validity;
            }
            $user->save();
            Bill::create([
                'uid'            => $user->id,
                'oid'            => $one->id,
                'type'           => Bill::TYPE_RECHARGE,
                'orderid'        => $one->orderid,
                'alipay_orderid' => $one->alipay_orderid,
                'gin'            => $one->golds,
                'rate'           => gconfig('rmbtogold'),
            ]);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            throw new MsgException('');
        }
    }

    /**
     * 充值+余额 支付
     * @param $price
     * @param $golds
     * @param $balance
     * @param $list
     * @return mixed
     * @throws MsgException
     */
    public static function consumeByPartRecharge($price, $golds, $balance, $list)
    {
        $user = Auth::user();
        DB::beginTransaction();
        try {
            $user->lock_golds   = $user->lock_golds + $golds;
            $user->lock_balance = $user->lock_balance + $balance;
            $user->save();
            $one = self::create([
                'uid'          => $user->id,
                'type'         => self::TYPE_CONSUME,
                'payment_type' => self::PTYPE_ALIPAY,
                'orderid'      => get_order_id(),
                'balance'      => $balance,
                'price'        => $price,
                'golds'        => $golds,
                'rate'         => gconfig('rmbtogold'),
                'status'       => self::STATUS_UNPAID
            ]);
            foreach ($list as $model) {
                $model->oid    = $one->id;
                $model->status = 2;
                $model->save();
            }
            DB::commit();
            return $one;
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e);
            throw new MsgException();
        }
    }

    /**
     * 完成消费付款
     * @param Order $one
     * @param $alipay_orderid
     * @throws MsgException
     */
    public static function payOrder(self $one, $alipay_orderid)
    {
        $user = User::find($one->uid);
        $list = ClickFarm::where('oid', $one->id)->get();
        DB::beginTransaction();
        try {
            $one->status         = self::STATUS_PAID;
            $one->alipay_orderid = $alipay_orderid;
            $one->save();
            $user->lock_golds   = $user->lock_golds - $one->golds;
            $user->golds        = $user->golds - $one->golds;
            $user->lock_balance = $user->lock_balance - $one->balance;
            $user->balance      = $user->balance - $one->balance;
            $user->save();
            Bill::create([
                'uid'            => $user->id,
                'oid'            => $one->id,
                'type'           => Bill::TYPE_CONSUME,
                'orderid'        => $one->orderid,
                'alipay_orderid' => $one->alipay_orderid,
                'out'            => $one->price - $one->balance,
                'gout'           => $one->golds,
                'rate'           => gconfig('rmbtogold'),
            ]);
            foreach ($list as $model) {
                event(new CfResults($model));
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw new MsgException();
        }
    }

    /**
     * 余额 支付
     * @param $price
     * @param $golds
     * @param $list
     * @throws MsgException
     */
    public static function consumeByBalance($price, $golds, $list)
    {
        $user = Auth::user();
        DB::beginTransaction();
        try {
            $user->golds   = $user->golds - $golds;
            $user->balance = $user->balance - $price;
            $user->save();
            $orderid = get_order_id();
            $one     = self::create([
                'uid'          => $user->id,
                'type'         => self::TYPE_CONSUME,
                'payment_type' => self::PTYPE_ALIPAY,
                'orderid'      => $orderid,
                'balance'      => $price,
                'price'        => $price,
                'golds'        => $golds,
                'rate'         => gconfig('rmbtogold'),
                'status'       => self::STATUS_PAID
            ]);
            Bill::create([
                'uid'     => $user->id,
                'oid'     => $one->id,
                'type'    => Bill::TYPE_CONSUME,
                'orderid' => $one->orderid,
                'gout'    => $golds,
                'rate'    => gconfig('rmbtogold'),
            ]);
            foreach ($list as $model) {
                $model->oid    = $one->id;
                $model->status = 2;
                $model->save();
                event(new CfResults($model));
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw new MsgException();
        }
    }

    public function cfs()
    {
        return $this->hasMany(ClickFarm::class, 'oid');
    }

    public function getTypeTextAttribute()
    {
        $arr = config('linepro.order_type');
        return $arr[$this->type];
    }

    public function getStatusTextAttribute()
    {
        $arr = config('linepro.order_status');
        return $arr[$this->status];
    }

    public function getPaymentTypeTextAttribute()
    {
        $arr = config('linepro.order_ptype');
        return $arr[$this->payment_type];
    }
}