<?php

/**
 * Created by PhpStorm.
 * User: zhou
 * Date: 2017/5/12
 * Time: 下午2:05
 */

namespace App;
use Illuminate\Database\Eloquent\Model;
class CfResult extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uid', 'cfid', 'asin', 'shop_id'
    ];

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
        1=>CfResult::STATUS_1,
        2=>CfResult::STATUS_2,
        3=>CfResult::STATUS_3,
        4=>CfResult::STATUS_4,
        5=>CfResult::STATUS_5,
        6=>CfResult::STATUS_6,
        7=>CfResult::STATUS_7,
        8=>CfResult::STATUS_8,
        9=>CfResult::STATUS_9,
    ];
    public function getStatusTextAttribute()
    {
        $text= CfResult::OUT_TEXT;
        return $text[$this->status];
    }
    protected $appends = ['status_text'];

}