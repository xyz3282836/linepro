<?php
/**
 * Created by PhpStorm.
 * User: zhou
 * Date: 2017/4/28
 * Time: 上午9:58
 */
namespace App;
use Illuminate\Database\Eloquent\Model;

class Recharge extends Model
{
    const STATUS_L1 = '充值失败';
    const STATUS_0 = '充值未审核';
    const STATUS_1 = '充值成功';
    public function getStatusTextAttribute()
    {
        $text=[
            -1=>Recharge::STATUS_L1,
            0=>Recharge::STATUS_0,
            1=>Recharge::STATUS_1,
        ];
        return $text[$this->status];
    }

    const TYPE_1 = '支付宝';
//    const TYPE_2 = '微信';
    const TYPE_OUT_TEXT = [
        1 => Recharge::TYPE_1,
//        2 => Recharge::TYPE_2
    ];
    public function getTypeTextAttribute()
    {
        $text=Recharge::TYPE_OUT_TEXT;
        return $text[$this->type];
    }

    protected $appends = ['status_text','type_text'];
}