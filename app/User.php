<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'shop_id', 'password','mobile','addr','management_type','shipping_addr','real_name','idcardpic','idcardno','amount'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    const STATUS_1 = '普通会员';
    const STATUS_2 = '认证会员';
    public function getLevelTextAttribute()
    {
        $text=[
            1=>User::STATUS_1,
            2=>User::STATUS_2,
        ];
        return $text[$this->level];
    }

    public function checkInfoIsCompleted(){
        if($this->mobile == ''){
            return false;
        }
        if($this->shipping_addr == ''){
            return false;
        }
        if($this->real_name == ''){
            return false;
        }
        if($this->idcardno == ''){
            return false;
        }
        if($this->idcardpic == ''){
            return false;
        }
        return true;
    }
}
