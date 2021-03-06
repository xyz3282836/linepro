<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    const TYPE_REGULAR = 1;
    const TYPE_VIP     = 2;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'shop_id', 'password', 'mobile', 'addr', 'management_type', 'shipping_addr', 'real_name', 'idcardpic', 'idcardno', 'golds', 'lock_golds', 'balance', 'lock_balance', 'last_login_time', 'is_evaluate'
    ];
    protected $appends = ['level_text'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getLevelTextAttribute()
    {
        $arr = config('linepro.user_level');
        return $arr[$this->level];
    }

    public function getEvaluateAttribute()
    {
        $arr = config('linepro.user_evaluate');
        return $arr[$this->is_evaluate];
    }

    public function checkInfoIsCompleted()
    {
        if ($this->mobile == '') {
            return false;
        }
        if ($this->shipping_addr == '') {
            return false;
        }
        if ($this->real_name == '') {
            return false;
        }
        if ($this->idcardno == '') {
            return false;
        }
        if ($this->idcardpic == '') {
            return false;
        }
        return true;
    }

    public function scopeType($query, $type)
    {
        if (!in_array($type, [self::TYPE_REGULAR, self::TYPE_VIP])) {
            return $query;
        }
        return $query->where('level', $type);
    }
}
