<?php
/**
 * Created by PhpStorm.
 * User: zhou
 * Date: 2017/4/23
 * Time: 上午10:49
 */
namespace App;
use Illuminate\Database\Eloquent\Model;

class Evaluate extends Model
{
    const STATUS_0 = '取消订单';
    const STATUS_1 = '待支付';
    const STATUS_2 = '已经支付';
    const STATUS_3 = '找寻买家中';
    const STATUS_4 = '买家找到';
    const STATUS_5 = '评价完成';
    public function getStatusTextAttribute()
    {
        $text=[
            0=>Evaluate::STATUS_0,
            1=>Evaluate::STATUS_1,
            2=>Evaluate::STATUS_2,
            3=>Evaluate::STATUS_3,
            4=>Evaluate::STATUS_4,
            5=>Evaluate::STATUS_5,
        ];
        return $text[$this->status];
    }
    protected $appends = ['status_text'];
}