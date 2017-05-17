<?php
/**
 * Created by PhpStorm.
 * User: zhou
 * Date: 2017/5/17
 * Time: 下午12:55
 */

namespace App;
use Illuminate\Database\Eloquent\Model;

class QuotaBill extends Model
{

    const TYPE_1   = '充值';
    const TYPE_2   = '刷单任务结果评价';
    const OUT_TEXT = [
        1 => QuotaBill::TYPE_1,
        2 => QuotaBill::TYPE_2,
    ];

    protected $appends = ['type_text'];

    public function getTypeTextAttribute()
    {
        $text = Bill::OUT_TEXT;
        return $text[$this->type];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uid','type','in','out','quota','taskid'
    ];

}