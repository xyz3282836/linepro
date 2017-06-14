<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    const CURRENCY_USD = 1;
    const CURRENCY_CAD = 2;
    const CURRENCY_GBP = 3;
    const CURRENCY_EUR = 4;
    const CURRENCY_JPY = 5;

    public static function getCurrency($site){
        switch ($site){
            case ClickFarm::SITE_US:
                return self::CURRENCY_USD;
                break;
            case ClickFarm::SITE_CA:
                return self::CURRENCY_CAD;
                break;
            case ClickFarm::SITE_UK:
                return self::CURRENCY_GBP;
                break;
            case ClickFarm::SITE_DE:
                return self::CURRENCY_EUR;
                break;
            case ClickFarm::SITE_FR:
                return self::CURRENCY_EUR;
                break;
            case ClickFarm::SITE_JP:
                return self::CURRENCY_JPY;
                break;
            case ClickFarm::SITE_IN:

                break;
            case ClickFarm::SITE_ES:
                return self::CURRENCY_EUR;
                break;
            case ClickFarm::SITE_NL:

                break;
            case ClickFarm::SITE_IT:
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
