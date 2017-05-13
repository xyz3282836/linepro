<?php
/**
 * Created by PhpStorm.
 * User: zhou
 * Date: 2017/4/28
 * Time: 上午9:58
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    const TYPE_0   = '综合';
    const TYPE_1   = '充值';
    const TYPE_2   = '刷单任务消费';
    const OUT_TEXT = [
        0 => Bill::TYPE_0,
        1 => Bill::TYPE_1,
        2 => Bill::TYPE_2,
    ];
    protected $fillable = [
        'uid', 'uid', 'type', 'orderid', 'out', 'amount', 'taskid'
    ];
    protected $appends = ['type_text'];

    public function getTypeTextAttribute()
    {
        $text = Bill::OUT_TEXT;
        return $text[$this->type];
    }


}