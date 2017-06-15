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
    protected $appends = ['status_text', 'delivery_type_text', 'from_site_text', 'time_type_text'];

    public function getStatusTextAttribute()
    {
        $arr = config('linepro.cf_status');
        return $arr[$this->status];
    }

    public function getDeliveryTypeTextAttribute()
    {
        $arr = config('linepro.delivery_typec');
        return $arr[$this->delivery_type];
    }

    public function getFromSiteTextAttribute()
    {
        $arr = config('linepro.from_site');
        return $arr[$this->from_site];
    }

    public function getTimeTypeTextAttribute()
    {
        $arr = config('linepro.time_type');
        return $arr[$this->time_type];
    }
}