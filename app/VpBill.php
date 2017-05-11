<?php
/**
 * Created by PhpStorm.
 * User: zhou
 * Date: 2017/5/11
 * Time: 上午11:24
 */

namespace App;
use Illuminate\Database\Eloquent\Model;

class VpBill extends Model
{
    const STATUS_1 = '购买中';
    const STATUS_2 = '购买完成';
    const STATUS_3 = '正在准备发货';
    const STATUS_4 = '已经发货';
    const STATUS_5 = '已经送达';
    const STATUS_6 = '订单完成可评价';
    const STATUS_7 = '正在尝试评价';
    const STATUS_8 = '评价失败';
    const STATUS_9 = '评价成功';
    const OUT_TEXT = [
        1=>VpBill::STATUS_1,
        2=>VpBill::STATUS_2,
        3=>VpBill::STATUS_3,
        4=>VpBill::STATUS_4,
        5=>VpBill::STATUS_5,
        6=>VpBill::STATUS_6,
        7=>VpBill::STATUS_7,
        8=>VpBill::STATUS_8,
        9=>VpBill::STATUS_9,
    ];
    public function getStatusTextAttribute()
    {
        $text= VpBill::OUT_TEXT;
        return $text[$this->status];
    }
    protected $appends = ['status_text'];
}
