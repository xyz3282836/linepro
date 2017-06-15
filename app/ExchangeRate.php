<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    const CURRENCY_USD = 1;//美元
    const CURRENCY_CAD = 2;//加拿大元
    const CURRENCY_GBP = 3;//英镑
    const CURRENCY_EUR = 4;//欧元
    const CURRENCY_JPY = 5;//日元

    const SITE_US = 1;//美国1
    const SITE_CA = 2;//加拿大2
    const SITE_UK = 3;//英国3
    const SITE_DE = 4;//德国4
    const SITE_FR = 5;//法国4
    const SITE_JP = 6;//日本5
    const SITE_IN = 7;//
    const SITE_ES = 8;//西班牙4
    const SITE_NL = 9;//
    const SITE_IT = 10;//意大利4

    public static function getCurrency($site){
        switch ($site){
            case self::SITE_US:
                return self::CURRENCY_USD;
                break;
            case self::SITE_CA:
                return self::CURRENCY_CAD;
                break;
            case self::SITE_UK:
                return self::CURRENCY_GBP;
                break;
            case self::SITE_DE:
                return self::CURRENCY_EUR;
                break;
            case self::SITE_FR:
                return self::CURRENCY_EUR;
                break;
            case self::SITE_JP:
                return self::CURRENCY_JPY;
                break;
            case self::SITE_IN:

                break;
            case self::SITE_ES:
                return self::CURRENCY_EUR;
                break;
            case self::SITE_NL:

                break;
            case self::SITE_IT:
                return self::CURRENCY_EUR;
                break;
        }
        return self::CURRENCY_USD;
    }

    public static function getCurrencyText($site){
        return self::where('id',self::getCurrency($site))->value('name');
    }

    public static function getRate($site){
        return self::where('id',self::getCurrency($site))->value('rate');
    }
}
