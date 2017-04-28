<?php
/**
 * Created by PhpStorm.
 * User: zhou
 * Date: 2017/4/23
 * Time: 上午9:51
 */


const MODEL_NOT_FOUNT = '';
const NO_ACCESS = '无权限';
const NO_ENOUGH_MONEY = '没有足够的余额，请先充值';
const ERROR_IDEMPOTENCE = '重复操作';




//订购日期
function get_order_id(){

    //订单号码主体（YYYYMMDDHHIISSNNNNNNNN）

    $order_id_main = date('YmdHis') . rand(10000000,99999999);

    //订单号码主体长度

    $order_id_len = strlen($order_id_main);

    $order_id_sum = 0;

    for($i=0; $i<$order_id_len; $i++){

        $order_id_sum += (int)(substr($order_id_main,$i,1));

    }

    //唯一订单号码（YYYYMMDDHHIISSNNNNNNNNCC）

    $order_id = $order_id_main . str_pad((100 - $order_id_sum % 100) % 100,2,'0',STR_PAD_LEFT);

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

function get_amount_clickfarm($cf){
    return config('linepro.clickfarm_price.fix') + $cf['final_price'] * $cf['task_num'];
}

function get_amount_evaluate($el){
    //TODO 判断是否为vp

    $price = config('linepro.clickfarm_price.fix') + config('linepro.clickfarm_price.vp') + config('linepro.clickfarm_price.video') + config('linepro.clickfarm_price.pic');

    return $price;
}


function success($data=''){
    $arr = [
        'code'=>1,
        'msg'=>'ok',
        'data'=>$data
    ];
    return json_encode($arr);
}

function error($msg){
    $arr = [
        'code'=>0,
        'msg'=>$msg,
        'data'=>''
    ];
    return json_encode($arr);
}