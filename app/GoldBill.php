<?php
/**
 * Created by PhpStorm.
 * User: zhou
 * Date: 2017/6/7
 * Time: 22:55
 */

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class GoldBill extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uid', 'type', 'orderid', 'in', 'out', 'rate', 'golds', 'taskid'
    ];

    public static function getByReg($uid, $gold)
    {
        self::insert([
            'uid'     => $uid,
            'type'    => 1,
            'orderid' => get_order_id(),
            'in'      => $gold,
            'rate'    => gconfig('rmbtogold'),
            'golds'   => $gold,
        ]);
    }
}