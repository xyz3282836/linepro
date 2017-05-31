<?php
/**
 * Created by PhpStorm.
 * User: zhou
 * Date: 2017/4/22
 * Time: 下午3:01
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class ClickFarm extends Model
{
    const STATUS_0 = '取消订单';
    const STATUS_1 = '待支付';
    const STATUS_2 = '已经支付';
    const STATUS_3 = '正在找寻代购账号';
    const STATUS_4 = '购买中';
    const STATUS_5 = '购买完成';
    const OUT_TEXT = [
        0 => ClickFarm::STATUS_0,
        1 => ClickFarm::STATUS_1,
        2 => ClickFarm::STATUS_2,
        3 => ClickFarm::STATUS_3,
        4 => ClickFarm::STATUS_4,
        5 => ClickFarm::STATUS_5,
    ];

    public static function getExceptText(){
        $arr = self::OUT_TEXT;
        array_shift($arr);
        return $arr;
    }

    public function getStatusTextAttribute()
    {
        $text=self::OUT_TEXT;
        return $text[$this->status];
    }

    protected $appends = ['status_text'];
}