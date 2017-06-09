<?php
/**
 * Created by PhpStorm.
 * User: zhou
 * Date: 2017/5/11
 * Time: 上午11:24
 */

namespace App;
use Illuminate\Database\Eloquent\Model;

class VipBill extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uid','rid','days','validity'
    ];

}
