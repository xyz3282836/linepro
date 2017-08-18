<?php

/**
 * Created by PhpStorm.
 * User: zhou
 * Date: 2017/5/12
 * Time: 下午2:05
 */

namespace App;

use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;

class CfResult extends Model
{
    const STATUS_ERROR           = 0;//购买失败
    const STATUS_WAITING         = 1;//待发货
    const STATUS_REMAIN_EVALUATE = 2;//待评价
    const STATUS_SUBMIT          = 3;//已提交
    const STATUS_SUCCESS         = 4;//评价成功
    const STATUS_FAILURE         = 5;//评价失败
    const STATUS_GOING           = 6;//

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uid', 'cfid', 'asin', 'shop_id', 'status'
    ];
    protected $appends = ['status_text'];
    private $msg = '';

    /**
     * 购买失败退款
     * @param CfResult $one
     */
    public function refund()
    {
        if ($this->status == self::STATUS_ERROR) {
            DB::beginTransaction();
            try {
                $result = $this;
                $uid    = $result->uid;
                $user   = $result->user;
                $cf     = $result->cf;
                $price  = round(($cf->transport + $cf->amount) / $cf->task_num, 2);
                $golds  = round($cf->golds / $cf->task_num, 2);
                $order  = Order::create([
                    'uid'     => $uid,
                    'type'    => Order::TYPE_REFUND,
                    'orderid' => get_order_id(),
                    'price'   => $price,
                    'golds'   => $golds,
                    'rate'    => gconfig('rmbtogold'),
                    'status'  => Order::STATUS_PAID
                ]);
                Bill::create([
                    'uid'     => $user->id,
                    'oid'     => $order->id,
                    'type'    => Bill::TYPE_REFUND,
                    'orderid' => $order->orderid,
                    'in'      => $price,
                    'gin'     => $golds,
                    'rate'    => gconfig('rmbtogold'),
                ]);
                $user->balance = $price;
                $user->golds   = $golds;
                $user->save();
                $result->oid = $order->id;
                $result->save();
                DB::commit();
                return true;
            } catch (\Throwable $e) {
                DB::rollBack();
                return false;
            }
        }
        return false;
    }

    public function getStatusTextAttribute()
    {
        $arr = config('linepro.cfresult_status');
        return $arr[$this->status];
    }

    /**
     * @return string
     */
    public function getMsg()
    {
        return $this->msg;
    }

    public function evaluate($user = null)
    {
        $one  = ClickFarm::find($this->cfid);
        $user = $user != null ? $user : Auth::user();
        if ($user->level == 1) {
            $weight = gconfig('regular.evaluate');
        } else {
            $weight = gconfig('vip.evaluate');
        }
        $waitcount = CfResult::where('cfid', $this->cfid)->whereIn('status', [1, 2])->count();
        $count     = CfResult::where('cfid', $this->cfid)->count();
        $waitcount--;
        if ($waitcount >= 0) {
            if (($one->golds / $one->grate / ($count - $waitcount) - gconfig('evaluate.cost') - $weight) <= 0) {
                $user->is_evaluate = 0;
                $user->save();
            }
        }

    }

    public function cf()
    {
        return $this->belongsTo(ClickFarm::class, 'cfid');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'uid');
    }
}