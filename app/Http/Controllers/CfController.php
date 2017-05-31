<?php
/**
 * Created by PhpStorm.
 * User: zhou
 * Date: 2017/5/11
 * Time: 上午11:14
 */

namespace App\Http\Controllers;


use App\CfResult;
use App\ClickFarm;
use App\Exceptions\MsgException;
use App\QuotaBill;
use Auth;
use Carbon\Carbon;
use DB;
use Mockery\Exception;

class CfController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 刷单任务
     * add:get
     */
    public function getAddClickFarm()
    {
        $base_exchange    = config('linepro.base_exchange.' . Auth::user()->level);
        $freight_exchange = config('linepro.freight_exchange.' . Auth::user()->level);
        return view('cf.add_clickfarm')->with([
            'base_exchange'    => $base_exchange,
            'freight_exchange' => $freight_exchange,
        ]);
    }

    /**
     * 刷单任务
     * add:post
     */
    public function postAddClickFarm()
    {
        $this->validate(request(), [
            'asin'          => 'required|min:1|max:24',
            'amazon_url'    => 'required|active_url',
            'amazon_pic'    => 'required|active_url',
            'amazon_title'  => 'required|min:2|max:50',
            'shop_id'       => 'required|min:2|max:50',
            'final_price'   => 'required',
            'task_num'      => 'required|integer',
            'delivery_addr' => 'required|min:5|max:50',
        ]);

        $pdata = request()->all();


        $pdata['amount']  = get_amount_clickfarm($pdata);
        $pdata['mixdata'] = json_encode([
            'key_word'              => '',
            'lower_classification1' => '',
            'lower_classification2' => '',
            'lower_classification3' => '',
            'lower_classification4' => '',
            'outside_website'       => '',
            'place'                 => '',
            'category'              => 1,
            'results'               => null,
            'first_attribute'       => '',
            'second_attribute'      => '',
            'refine'                => null,
            'attribute_group1'      => '',
            'attribute1'            => '',
            'attribute_group2'      => '',
            'attribute2'            => '',
            'attribute_group3'      => '',
            'attribute3'            => '',
            'sort_by'               => 1,
            'page'                  => 1,
            'ba_place'              => 1,
            'ba_asin'               => '',
        ]);

        $model                   = new ClickFarm;
        $model->uid              = Auth::user()->id;
        $model->orderid          = get_order_id();
        $model->platform_type    = 1;
        $model->us_exchange_rate = config('linepro.us_exchange_rate');
        $model->asin             = $pdata['asin'];
        $model->task_num         = $pdata['task_num'];
        $model->final_price      = $pdata['final_price'];
        $model->shop_id          = $pdata['shop_id'];
        $model->amazon_url       = $pdata['amazon_url'];
        $model->amazon_pic       = $pdata['amazon_pic'];
        $model->amazon_title     = $pdata['amazon_title'];
        $model->delivery_addr    = $pdata['delivery_addr'];
        //1.0
        $model->is_fba           = 1;
        $model->discount_code    = '';
        $model->is_reviews       = 0;
        $model->is_link          = 0;
        $model->is_sellerrank    = 0;
        $model->contrast_asin    = '';
        $model->brower           = 1;
        $model->priority         = 1;
        $model->flow_port        = 1;
        $model->flow_source      = 1;
        $model->browse_step      = 1;
        $model->mixdata          = $pdata['mixdata'];
        $model->interval_time    = 1;
        $model->start_time       = Carbon::now()->toDateTimeString();
        $model->customer_message = '';
        $model->amount           = $pdata['amount'];
        $model->save();
        return redirect('card');
    }

    /**
     * 购物车 刷单任务
     * list
     */
    public function listCardClickFarm()
    {
        $list = ClickFarm::where('uid', Auth::user()->id)->where('status', 1)->orderBy('id', 'desc')->paginate(config('linepro.perpage'));
        return view('cf.list_card')->with('tname', '购物车商品列表')->with('list', $list);
    }

    /**
     * 购物车车删除
     * @return string
     */
    public function postCancle()
    {
        $id    = request('id', 0);
        $model = ClickFarm::find($id);
        if (!$model) {
            return error(MODEL_NOT_FOUNT);
        }
        if ($model->uid != Auth::user()->id) {
            return error(NO_ACCESS);
        }
        if ($model->status != 1) {
            return error(NO_ACCESS);
        }
        $model->status = 0;
        $model->save();
        return success();
    }

    /**
     * 订单页 刷单任务
     * list
     */
    public function listTradeClickFarm()
    {
        $start  = request('start');
        $end    = request('end');
        $asin   = request('asin');
        $status = request('status', 1);

        $list = ClickFarm::where('uid', Auth::user()->id);
        if ($start != null && $end != null) {
            $list->whereBetween('updated_at', [$start, $end]);
        }
        if ($asin != null) {
            $list->where('asin', $asin);
        }
        if ($status != 0) {
            $list->where('status', $status);
        }else{
            $list->where('status', '>',0);
        }
        $list = $list->orderBy('id', 'desc')->paginate(config('linepro.perpage'));
        return view('cf.list_clickfarm')->with('tname', '已购买商品列表')->with([
            'list'   => $list,
            'start'  => $start,
            'end'    => $end,
            'asin'   => $asin,
            'status' => $status,
        ]);
    }

    /**
     * 刷单任务结果表
     * list
     */
    public function listCfResult($id)
    {
        $start  = request('start');
        $end    = request('end');
        $asin   = request('asin');
        $status = request('status', 1);
        $model = ClickFarm::find($id);
        if (!$model) {
            return error(MODEL_NOT_FOUNT);
        }
        $list = CfResult::where('cfid', $id);
        if ($start != null && $end != null) {
            $list->whereBetween('updated_at', [$start, $end]);
        }
        if ($asin != null) {
            $list->where('asin', $asin);
        }
        $list = $list->where('status', $status)->orderBy('id', 'desc')->paginate(config('linepro.perpage'));
        return view('cf.list_cf_result')->with('tname', '已购买商品详情列表')->with([
            'list'   => $list,
            'model'  => $model,
            'start'  => $start,
            'end'    => $end,
            'asin'   => $asin,
            'status' => $status,
        ]);
    }

    /**
     * 刷单评价
     */
    public function evaluate()
    {
        $id      = request('id', 0);
        $star    = request('star');
        $title   = request('title');
        $content = request('content');

        $model = CfResult::find($id);
        if (!$model) {
            return error(MODEL_NOT_FOUNT);
        }
        if ($model->uid != Auth::user()->id) {
            return error(NO_ACCESS);
        }

        $model->star    = $star;
        $model->title   = $title;
        $model->content = $content;
        $model->status  = 7;
        $model->save();
        return success();
    }

}