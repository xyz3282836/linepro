<?php
/**
 * Created by PhpStorm.
 * User: zhou
 * Date: 2017/4/28
 * Time: 上午9:58
 */

namespace App;

use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    const TYPE_SYS = 0;//系统送
    const TYPE_RECHARGE = 1;//充值送
    const TYPE_CONSUME = 2;//正常订单
    const TYPE_REFUND = 3;//退款

    protected $appends = ['type_text'];

    public function getTypeTextAttribute()
    {
        $arr = config('linepro.bill_type');
        return $arr[$this->type];
    }

    protected $fillable = [
        'uid', 'type', 'orderid', 'in', 'out', 'gin', 'gout', 'rate', 'oid'
    ];


    /**
     * 系统送
     * @param $gold
     * @param null $uid
     */
    public static function getGoldByReg($golds, $user=null)
    {
        $user=$user!=null?$user:Auth::user();
        $user->golds = $golds;
        $user->save();
        self::create([
            'uid'     => $user->id,
            'type'    => self::TYPE_SYS,
            'orderid' => get_order_id(),
            'gin'     => $golds,
            'rate'    => gconfig('rmbtogold'),
        ]);
    }

}