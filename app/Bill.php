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
    const TYPE_1 = '充值';
    const TYPE_2 = '刷单任务消费';
    const TYPE_3 = '评论任务消费';
    public function getTypeTextAttribute()
    {
        $text=[
            1=>Bill::TYPE_1,
            2=>Bill::TYPE_2,
            3=>Bill::TYPE_3,
        ];
        return $text[$this->type];
    }
    protected $fillable = [
        'uid','uid','type','orderid','out','amount','taskid'
    ];


    protected $appends = ['type_text'];




}