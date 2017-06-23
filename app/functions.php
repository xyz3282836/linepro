<?php
/**
 * Created by PhpStorm.
 * User: zhou
 * Date: 2017/4/23
 * Time: 上午9:51
 */


use Omnipay\Omnipay;
const MODEL_NOT_FOUNT   = '无此数据';
const NO_ACCESS         = '无权限';
const NO_ENOUGH_BALANCE = '没有足够的余额，请先充值';
const NO_ENOUGH_GOLDS   = '没有足够的金币，请先充值';
const ERROR_IDEMPOTENCE = '重复操作';
const ERROR_SYSTEM      = '系统错误';
const ERROR_PARAM       = '参数错误';

//订购日期
function get_order_id()
{

    //订单号码主体（YYYYMMDDHHIISSNNNNNNNN）

    $order_id_main = date('YmdHis') . rand(10000000, 99999999);

    //订单号码主体长度

    $order_id_len = strlen($order_id_main);

    $order_id_sum = 0;

    for ($i = 0; $i < $order_id_len; $i++) {

        $order_id_sum += (int)(substr($order_id_main, $i, 1));

    }

    //唯一订单号码（YYYYMMDDHHIISSNNNNNNNNCC）

    $order_id = $order_id_main . str_pad((100 - $order_id_sum % 100) % 100, 2, '0', STR_PAD_LEFT);

    return $order_id;
}

function p($arr)
{
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
}

function get_amount_clickfarm($model)
{
    $exchange         = config('linepro.base_exchange.' . Auth::user()->level);
    $freight_exchange = config('linepro.freight_exchange.' . Auth::user()->level);
    if ($model['delivery_addr'] == '美国转运仓') {
        $exchange += $freight_exchange;
    }
    $rate   = round(config('linepro.us_exchange_rate'), 1);
    $result = ($exchange + $model['final_price'] * $rate) * $model['task_num'];
    return round($result, 2);
}


function success($data = '')
{
    $arr = [
        'code' => 1,
        'msg'  => 'ok',
        'data' => $data
    ];
    return json_encode($arr);
}

function error($msg)
{
    $arr = [
        'code' => 0,
        'msg'  => $msg,
        'data' => ''
    ];
    return json_encode($arr);
}

function get_alipay()
{
    $gateway = Omnipay::create('Alipay_AopPage');
    $gateway->setSignType(config('alipay.sign_type')); //RSA/RSA2
    $gateway->setAppId(config('alipay.app_id'));
    $gateway->setPrivateKey(config('alipay.app_private_key'));
    $gateway->setAlipayPublicKey(config('alipay.alipay_public_key'));
    $gateway->setReturnUrl(config('alipay.return_url'));
    $gateway->setNotifyUrl(config('alipay.notify_url'));
    $gateway->setEnvironment(config('alipay.env'));

    return $gateway;
}

function mask_number($num, $star_num = 4)
{
    $star_num = $star_num >= strlen($num) ? strlen($num) - 2 : (int)$star_num;
    if ($star_num % 2 == 0) {
        $star_left = $star_right = $star_num / 2;
    } else {
        $star_left  = floor($star_num / 2);
        $star_right = $star_num - $star_left;
    }
    $len    = strlen($num);
    $left   = floor($len / 2) - $star_left;
    $right  = round($len / 2) - $star_right;
    $middle = $len - $left - $right;
    $result = substr($num, 0, $left) . str_repeat("*", $middle) . substr($num, $left + $middle, $right);
    return $result;
}

function mask_name($str)
{
    $num = mb_strlen($str, 'UTF-8');
    $end = mb_substr($str, -1, 1, 'UTF-8');
    return str_repeat('*', $num - 1) . $end;
}

function mask_email($email)
{
    $arr   = explode('@', $email);
    $first = $arr[0];
    return substr($first, 0, strlen($first) - 4) . '****@' . $arr[1];
}

function gconfig($key)
{
    $value = Cache::get($key, false);
    if ($value === false) {
        $value = App\Gconfig::where('key', $key)->value('value');
        Cache::forever($key, $value);
    }
    return $value;
}

function set_gconfig($id,$value)
{
    $key = App\Gconfig::where('id', $id)->value('key');
    Cache::forever($key, $value);
}

function get_rate($site)
{
    return App\ExchangeRate::getRate($site);
}

function get_currency($site)
{
    return App\ExchangeRate::getCurrencyText($site);
}

function get_cf_price($cf)
{
    $trans         = gconfig('cost.transport');
    $rmbtogold     = gconfig('rmbtogold');
    $rate          = get_rate($cf->from_site);
    $srate         = get_srate();
    $tmp           = round($cf->task_num * $cf->final_price * $rate * $srate[$cf->time_type]['rate'] * $rmbtogold);
    $tmp           = $tmp < $srate[$cf->time_type]['mingolds'] ? $srate[$cf->time_type]['mingolds'] : $tmp;
    $cf->golds     = $tmp;
    $cf->rate      = $rate;
    $cf->grate     = $rmbtogold;
    $cf->transport = $cf->delivery_type == 1 ? 0 : round($cf->task_num * $trans, 2);
    $cf->amount    = round(($cf->task_num * $cf->final_price * $rate + $cf->transport), 2);
}

function get_srate()
{
    if (Auth::user()->level == 1) {
        $arr = [
            1 => [
                'mingolds' => gconfig('regular.service.one.min'),
                'rate'     => gconfig('regular.service.one.rate')
            ],
            3 => [
                'mingolds' => gconfig('regular.service.three.min'),
                'rate'     => gconfig('regular.service.three.rate')
            ]
        ];
    } else {
        $arr = [
            1 => [
                'mingolds' => gconfig('vip.service.one.min'),
                'rate'     => gconfig('vip.service.one.rate')
            ],
            3 => [
                'mingolds' => gconfig('vip.service.three.min'),
                'rate'     => gconfig('vip.service.three.rate')
            ]
        ];
    }
    return $arr;
}