<?php
/**
 * Created by PhpStorm.
 * User: zhou
 * Date: 2017/5/11
 * Time: 上午11:14
 */

namespace App\Http\Controllers;


use App\ClickFarm;
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
    public function getAddClickFarm(){
        return view('cf.add_clickfarm');
    }

    /**
     * 刷单任务
     * add:post
     */
    public function postAddClickFarm(){
        $this->validate(request(),[
            'asin'=>'required|min:1|max:24',
            'amazon_url'=>'required|active_url',
            'amazon_pic'=>'required|active_url',
            'amazon_title'=>'required|min:2|max:50',
            'shop_id'=>'required|min:2|max:50',
            'final_price'=>'required',
            'task_num'=>'required|integer',
            'delivery_addr'=>'required|min:5|max:50',
        ]);

        $pdata = request()->all();

        $pdata['mixdata'] = json_encode([
            'key_word'=>'',

            'lower_classification1'=>'',
            'lower_classification2'=>'',
            'lower_classification3'=>'',
            'lower_classification4'=>'',

            'outside_website'=>'',
            'place'=>'',

            'category'=>1,

            'results'=>null,
            'first_attribute'=>'',
            'second_attribute'=>'',

            'refine'=>null,
            'attribute_group1'=>'',
            'attribute1'=>'',
            'attribute_group2'=>'',
            'attribute2'=>'',
            'attribute_group3'=>'',
            'attribute3'=>'',

            'sort_by'=>1,

            'page'=>1,

            'ba_place'=>1,
            'ba_asin'=>'',
        ]);
        $pdata['amount'] = get_amount_clickfarm($pdata);

        $model = new ClickFarm;
        $model->uid = Auth::user()->id;
        $model->platform_type = 1;
        $model->asin = $pdata['asin'];
        $model->task_num = $pdata['task_num'];
        $model->final_price = $pdata['final_price'];
        $model->shop_id = $pdata['shop_id'];
        $model->amazon_url = $pdata['amazon_url'];
        $model->amazon_pic = $pdata['amazon_pic'];
        $model->amazon_title = $pdata['amazon_title'];
        $model->delivery_addr = $pdata['delivery_addr'];

        //1.0
        $model->is_fba = 1;
        $model->discount_code = '';

        $model->is_reviews = 0;
        $model->is_link = 0;
        $model->is_sellerrank = 0;

        $model->contrast_asin = '';
        $model->brower = 1;
        $model->priority = 1;
        $model->flow_port = 1;
        $model->flow_source = 1;
        $model->browse_step = 1;
        $model->mixdata = $pdata['mixdata'];

        $model->interval_time = 1;
        $model->start_time = Carbon::now()->toDateTimeString();
        $model->customer_message = '';
        $model->amount = $pdata['amount'];
        $model->save();

        return redirect('clickfarmlist');
    }

    /**
     * 刷单任务
     * list
     */
    public function listClickFarm(){
        switch (request('type','nodone')){
            case 'done':
                $status = [5];
                $tname = '已完成刷单任务列表';
                break;
            case 'nodone':
                $status = [0,1,2,3,4];
                $tname = '未完成刷单任务列表';
                break;
            default:
                throw new Exception();

        }
        $list = ClickFarm::where('uid',Auth::user()->id)->whereIn('status',$status)->orderBy('id','desc')->paginate(10);
        return view('index.list_clickfarm')->with('tname',$tname)->with('list',$list);
    }

}