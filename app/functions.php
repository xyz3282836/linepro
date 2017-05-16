<?php
/**
 * Created by PhpStorm.
 * User: zhou
 * Date: 2017/4/23
 * Time: 上午9:51
 */


use Omnipay\Omnipay;
const MODEL_NOT_FOUNT   = '';
const NO_ACCESS         = '无权限';
const NO_ENOUGH_MONEY   = '没有足够的余额，请先充值';
const ERROR_IDEMPOTENCE = '重复操作';
const ERROR_SYSTEM      = '系统错误';


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

//function get_amount_clickfarm($cf){
//    $price = config('linepro.clickfarm_price');
//    $one = 0;
//    if($cf['is_reviews'] == 1){
//        $one += $price['reviews'];
//    }
//    if($cf['specified_asin'] != null){
//        $one += $price['asin'];
//    }
//    if($cf['brower'] == 2){
//        $one += $price['deep'];
//    }
//    if($cf['priority'] == 3){
//        $one += $price['ad'];
//    }
//    if($cf['flow_port'] == 2){
//        $one += $price['mobile'];
//    }
//    if($cf['flow_source'] == 2){
//        $one += $price['ab'];
//    }
//    if($cf['browse_step'] == 1 || $cf['browse_step'] == 2){
//        $one += $price['page'][$cf['page']];
//    }
//    $one += $cf['final_price'];
//    return $one * $cf['task_num'];
//}

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