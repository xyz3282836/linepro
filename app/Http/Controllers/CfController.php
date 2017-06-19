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
use App\Order;
use App\QuotaBill;
use Auth;
use Carbon\Carbon;

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
        $site      = request('site', 1);
        $trans     = gconfig('cost.transport');
        $rmbtogold = gconfig('rmbtogold');
        return view('cf.add_clickfarm')->with([
            'rate'      => get_rate($site),
            'ctext'     => get_currency($site),
            'srate'     => json_encode(get_srate()),
            'trans'     => $trans,
            'rmbtogold' => $rmbtogold,
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
            'shop_name'     => 'max:50',
            'final_price'   => 'required',
            'task_num'      => 'required|integer',
            'delivery_addr' => 'max:50',
            'from_site'     => 'required|integer',
            'time_type'     => 'required|integer',
            'delivery_type' => 'required|integer',
        ]);

        $pdata = request()->all();
        if ($pdata['delivery_type'] == 1) {
            $pdata['delivery_addr'] = '';
        }

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

        $model                = new ClickFarm;
        $model->uid           = Auth::user()->id;
        $model->platform_type = 1;
        $model->asin          = $pdata['asin'];
        $model->task_num      = $pdata['task_num'];
        $model->final_price   = $pdata['final_price'];
        $model->shop_id       = $pdata['shop_id'];
        $model->amazon_url    = $pdata['amazon_url'];
        $model->amazon_pic    = $pdata['amazon_pic'];
        $model->amazon_title  = $pdata['amazon_title'];
        $model->delivery_addr = $pdata['delivery_addr'];
        $model->from_site     = $pdata['from_site'];
        $model->time_type     = $pdata['time_type'];
        $model->delivery_type = $pdata['delivery_type'];
        $model->shop_name     = $pdata['shop_name'];
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
        $model->start_time       = Carbon::now();
        $model->customer_message = '';
        $model->amount           = $pdata['amount'];
        get_cf_price($model);
        $model->save();
        return redirect('card');
    }

    /**
     * 购物车 刷单任务
     * list
     */
    public function listCardClickFarm()
    {
        $list = ClickFarm::where('uid', Auth::user()->id)->where('status', 1)->orderBy('id', 'desc')->get()->toJson();
        return view('cf.list_card')->with('tname', '购物车商品列表')->with('list', $list);
    }

    public function listOrder(){
        $start = request('start');
        $end   = request('end');
        $type  = request('type', 1);

        $table = Order::with('cfs')->where('uid', Auth::user()->id)->where('status',$type);
        if ($start != null && $end != null) {
            $table->whereBetween('created_at', [$start, $end]);
        }
        $list = $table->orderBy('id', 'desc')->paginate(10);
        return view('cf.list_order')->with('tname', '订单管理')->with('list', $list)->with([
            'start' => $start,
            'end'   => $end,
            'type'  => $type
        ]);
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
     * 刷单任务结果表
     * list
     */
    public function listCfResult($id)
    {
        $start  = request('start');
        $end    = request('end');
        $asin   = request('asin');
        $status = request('status', 1);
        $model  = ClickFarm::find($id);
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
            'id'  => $model->id,
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
        $user = Auth::user();
        if ($model->uid != $user->id) {
            return error(NO_ACCESS);
        }
        if($model->status != CfResult::STATUS_REMAIN_EVALUATE){
            return error(NO_ACCESS);
        }
        if(!$user->is_evaluate){
            return error('此账号已被封禁');
        }
        $model->star    = $star;
        $model->title   = $title;
        $model->content = $content;
        $model->status  = 3;
        $model->save();
        $model->evaluate($user);
        return success();
    }

}