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
    const STATUS_WAITING         = 1;//待发货
    const STATUS_REMAIN_EVALUATE = 2;//待评价
    const STATUS_SUBMIT          = 3;//已提交
    const STATUS_SUCCESS         = 4;//评价成功
    const STATUS_FAILURE         = 5;//评价失败

    const THIS_DONE              = '已经评价过';
    const LEVE1_HAS_DONE         = '该asin已经评价过';
    const LEVE2_NOT_ENOUGH_QUOTA = '评价配额不足，需要充值';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uid', 'cfid', 'asin', 'shop_id', 'status'
    ];
    protected $appends = ['status_text'];
    private $msg = '';

    public function getStatusTextAttribute()
    {
        $arr = config('linepro.cfresult_status');
        return $arr[$this->status];
    }

    /**
     * @return string
     */
    public function getMsg()
    {
        return $this->msg;
    }
}