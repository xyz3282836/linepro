<?php
/**
 * Created by PhpStorm.
 * User: zhou
 * Date: 2017/6/7
 * Time: 22:55
 */
namespace App;
use Illuminate\Database\Eloquent\Model;

class GoldBill extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    ];

    const Rate = 100;
}