<?php

/**
 * Created by PhpStorm.
 * User: zhou
 * Date: 2017/5/12
 * Time: 下午2:05
 */

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class CfResult extends Model
{
    const STATUS_WAITING         = 1;//待发货
    const STATUS_REMAIN_EVALUATE = 2;//待评价
    const STATUS_SUBMIT          = 3;//已提交
    const STATUS_SUCCESS         = 4;//评价成功
    const STATUS_FAILURE         = 5;//评价失败

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

    public function evaluate($user=null){
        $one = ClickFarm::find($this->cfid);
        $user = $user!=null?$user:Auth::user();
        if ($user->level == 1){
            $weight = gconfig('regular.evaluate');
        }else{
            $weight = gconfig('vip.evaluate');
        }
        $waitcount = CfResult::where('cfid',$this->cfid)->whereIn('status',[1,2])->count();
        $count = CfResult::where('cfid',$this->cfid)->count();
        $waitcount--;
        if ($waitcount>=0){
            if(($one->golds/$one->grate/($count-$waitcount)-20-$weight) <= 0){
                $user->is_evaluate = 0;
                $user->save();
            }
        }

    }
}