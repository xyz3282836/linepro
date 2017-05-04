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
        'name', 'email', 'shop_id', 'password','mobile','addr','management_type'
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
    const STATUS_2 = '年费会员';
    public function getLevelTextAttribute()
    {
        $text=[
            1=>User::STATUS_1,
            2=>User::STATUS_2,
        ];
        return $text[$this->level];
    }
}
