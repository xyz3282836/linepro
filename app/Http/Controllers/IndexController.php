<?php

namespace App\Http\Controllers;


use App\ClickFarm;
use Auth;
use Mockery\Exception;
use Validator;

class IndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * 刷单任务
     * add:post
     */
    public function listClickFarm(){
        $list = ClickFarm::where('uid',Auth::getUser()->id)->where('status','1')->orderBy('id','desc')->paginate(10);
        return view('index.list_clickfarm')->with('list',$list);
    }

    /**
     * 刷单任务
     * view
     */
    public function getViewClickFarm($id){
        $cf = ClickFarm::find($id);
        if($cf->uid != Auth::getUser()->id){
            throw new Exception();
        }
        $cf->mixdata = json_decode($cf->mixdata,true);
        return view('index.view_clickfarm')->with('cf',$cf)->with('mix',$cf->mixdata);
    }

    /**
     * 刷单任务
     * add:get
     */
    public function getAddClickFarm(){
        return view('index.add_clickfarm');
    }

    /**
     * 刷单任务
     * add:post
     */
    public function postAddClickFarm(){
        $pdata = request()->all();
        $pdata['contrast_asin'] = implode(',',array_diff($pdata['contrast_asin'],[null]));
        $pdata['results'] = request('results',null);
        $pdata['refine'] = request('refine',null);
        $pdata['customer_message'] = request('customer_message')!=null?:'';
        $pdata['specified_asin'] = request('specified_asin',null);
        $validator = Validator::make($pdata,[
            'platform_type'=>'required',
            'asin'=>'required',
            'is_fba'=>'required|integer',
            'final_price'=>'required|integer',
            'is_reviews'=>'required|integer',
            'specified_asin'=>'nullable|size:24',
            'contrast_asin'=>'',
            'brower'=>'required|integer',
            'priority'=>'required|integer',
            'flow_port'=>'required|integer',

            'flow_source'=>'required|integer',
            'browse_step'=>'required|integer',

            'key_word'=>'',

            'lower_classification1'=>'',
            'lower_classification2'=>'',
            'lower_classification3'=>'',
            'lower_classification4'=>'',

            'outside_website'=>'',
            'place'=>'',

            'category'=>'integer',

            'results'=>'nullable|integer',
            'first_attribute'=>'',
            'second_attribute'=>'',

            'refine'=>'nullable|integer',
            'attribute_group1'=>'',
            'attribute1'=>'',
            'attribute_group2'=>'',
            'attribute2'=>'',
            'attribute_group3'=>'',
            'attribute3'=>'',

            'sort_by'=>'integer',
            'page'=>'integer',

            'ba_place'=>'',
            'ba_asin'=>'',

            'task_num'=>'required|integer',
            'start_time'=>'required|date_format:Y-m-d H:i|after:today',
            'interval_time'=>'required|integer',
            'customer_message'=>'max:300',
        ]);

        if($validator->fails()){
            p($validator->errors());
        }
        $pdata['mixdata'] = json_encode([
            'key_word'=>$pdata['key_word'],

            'lower_classification1'=>$pdata['lower_classification1'],
            'lower_classification2'=>$pdata['lower_classification2'],
            'lower_classification3'=>$pdata['lower_classification3'],
            'lower_classification4'=>$pdata['lower_classification4'],

            'outside_website'=>$pdata['outside_website'],
            'place'=>$pdata['place'],

            'category'=>$pdata['category'],

            'results'=>$pdata['results'],
            'first_attribute'=>$pdata['first_attribute'],
            'second_attribute'=>$pdata['second_attribute'],

            'refine'=>$pdata['refine'],
            'attribute_group1'=>$pdata['attribute_group1'],
            'attribute1'=>$pdata['attribute1'],
            'attribute_group2'=>$pdata['attribute_group2'],
            'attribute2'=>$pdata['attribute2'],
            'attribute_group3'=>$pdata['attribute_group3'],
            'attribute3'=>$pdata['attribute3'],

            'sort_by'=>$pdata['sort_by'],

            'page'=>$pdata['page'],

            'ba_place'=>$pdata['ba_place'],
            'ba_asin'=>$pdata['ba_asin'],
        ]);
        $pdata['orderid'] = get_order_id();
        $pdata['amount'] = get_amount($pdata);

        $cf = new ClickFarm;
        $cf->uid = Auth::getUser()->id;
        $cf->platform_type = $pdata['platform_type'];
        $cf->asin = $pdata['asin'];
        $cf->is_fba = $pdata['is_fba'];
        $cf->discount_code = $pdata['discount_code'];
        $cf->final_price = $pdata['final_price'];
        $cf->is_reviews = $pdata['is_reviews'];
        $cf->specified_asin = $pdata['specified_asin'];
        $cf->contrast_asin = $pdata['contrast_asin'];
        $cf->brower = $pdata['brower'];
        $cf->priority = $pdata['priority'];
        $cf->flow_port = $pdata['flow_port'];
        $cf->flow_source = $pdata['flow_source'];
        $cf->browse_step = $pdata['browse_step'];
        $cf->mixdata = $pdata['mixdata'];
        $cf->task_num = $pdata['task_num'];
        $cf->start_time = $pdata['start_time'];
        $cf->interval_time = $pdata['interval_time'];
        $cf->customer_message = $pdata['customer_message'];
        $cf->orderid = $pdata['orderid'];
        $cf->amount = $pdata['amount'];
        $cf->save();

        return redirect('clickfarmlist?type=nodone');
    }

    /**
     * 运行环境信息
     */
    public function getInfo(){
        phpinfo();
    }
}