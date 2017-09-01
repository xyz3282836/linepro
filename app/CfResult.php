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
    const STATUS_REFUND = -1;//购买失败,已退款
    const STATUS_ERROR = 0;//购买失败
    const STATUS_WAITING = 1;//代购中
    const STATUS_DELIVERED = 2;//已发货
    const STATUS_SUCCESS = 3;//成功送达
    const STATUS_WAITSEND = 4;//待发货

    const ESTATUS_BEFORE_SUBMIT = 1;//未提交
    const ESTATUS_SUBMIT = 2;//已提交
    const ESTATUS_SYNC = 3;//同步
    const ESTATUS_LOCK = 4;//锁定
    const ESTATUS_SUCCESS = 5;//评价成功
    const ESTATUS_FAILURE = 6;//评价失败
    const ESTATUS_REPEAT = 7;//评价重复

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uid', 'cfid', 'asin', 'shop_id', 'status'
    ];
    protected $appends = ['status_text', 'estatus_text', 'etime'];
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
                $user->balance += $price;
                $user->golds   += $golds;
                $user->save();
                $result->oid    = $order->id;
                $result->status = self::STATUS_REFUND;
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
        $nosubmitcount = CfResult::where('cfid', $this->cfid)->where('estatus', 1)->count();
        $allcount      = $one->task_num;
        $submitcount   = $allcount - $nosubmitcount;
        if ($submitcount > 0) {
            if (($one->golds / $one->grate / ($submitcount) - gconfig('evaluate.cost') - $weight) <= 0) {
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

    public function getEstatusTextAttribute()
    {
        $arr = config('linepro.cfresult_estatuss');
        return $arr[$this->estatus];
    }

    public function getStatusTextAttribute()
    {
        $arr = config('linepro.cfresult_statuss');
        if (isset($arr[$this->status])) {
            return $arr[$this->status];
        }
        return '';
    }

    public function getEtimeAttribute()
    {
        return date('Y-m-d', strtotime("+7 day", strtotime($this->updated_at)));
    }
}