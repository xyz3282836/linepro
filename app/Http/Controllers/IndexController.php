<?php

namespace App\Http\Controllers;


use App\Bill;
use App\ClickFarm;
use App\Recharge;
use Auth;
use App\Evaluate;
use Barryvdh\Debugbar\Middleware\Debugbar;
use DB;
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
     * 评价任务
     * add:post
     */
    public function listEvaluate(){
        switch (request('type','nodone')){
            case 'done':
                $status = [5];
                $tname = '已完成评价任务列表';
                break;
            case 'nodone':
                $status = [0,1,2,3,4];
                $tname = '未完成评价任务列表';
                break;
            default:
                throw new Exception();

        }
        $list = Evaluate::where('uid',Auth::user()->id)->whereIn('status',$status)->orderBy('id','desc')->paginate(10);
        return view('index.list_evaluate')->with('tname',$tname)->with('list',$list);
    }


    /**
     * 刷单任务
     * add:post
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

    /**
     * 刷单任务
     * view
     */
    public function getViewClickFarm($id){
        $cf = ClickFarm::find($id);
        if($cf->uid != Auth::user()->id){
            throw new Exception();
        }
        $cf->mixdata = json_decode($cf->mixdata,true);
        return view('index.view_clickfarm')->with('cf',$cf)->with('mix',$cf->mixdata);
    }

    /**
     * 评价任务
     * view
     */
    public function getViewEvaluate($id){
        $el = Evaluate::find($id);
        if($el->uid != Auth::user()->id){
            throw new Exception();
        }
        return view('index.view_evaluate')->with('el',$el);
    }

    /**
     * 充值
     * view
     */
    public function getViewRecharge($id){
        $one = Recharge::find($id);
        if($one->uid != Auth::user()->id){
            throw new Exception();
        }
        return view('pay.view_recharge')->with('one',$one);
    }

    /**
     * 刷单任务
     * add:get
     */
    public function getAddClickFarm(){
        return view('index.add_clickfarm');
    }

    /**
     * 评价任务
     * add:get
     */
    public function getAddEvaluate(){
        $list = ClickFarm::where('uid',Auth::user()->id)->where('status',2)->limit(30)->get();
        return view('index.add_evaluate')->with('list',$list);
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
            'final_price'=>'required',
            'is_reviews'=>'required|integer',
            'is_link'=>'required|integer',
            'is_sellerrank'=>'required|integer',
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
            'interval_time'=>'required|integer|max:100',
            'customer_message'=>'max:300',
        ]);

        if($validator->fails()){
            foreach($validator->errors()->getMessages() as $k=>$v){
                p($k.'=>'.$v[0]);
            }
            die;
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
        $pdata['amount'] = get_amount_clickfarm($pdata);

        $cf = new ClickFarm;
        $cf->uid = Auth::user()->id;
        $cf->shop_id = Auth::user()->shop_id;
        $cf->platform_type = $pdata['platform_type'];
        $cf->asin = $pdata['asin'];
        $cf->is_fba = $pdata['is_fba'];
        $cf->discount_code = $pdata['discount_code'];
        $cf->final_price = $pdata['final_price'];
        $cf->is_reviews = $pdata['is_reviews'];
        $cf->is_link = $pdata['is_link'];
        $cf->is_sellerrank = $pdata['is_sellerrank'];
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
        $cf->amount = $pdata['amount'];
        $cf->orderid = get_order_id();
        $cf->save();

        return redirect('clickfarmlist');
    }

    /**
     * 评价任务
     * add:post
     */
    public function postAddEvaluate(){
        $pdata = request()->all();
        $pdata['cfid'] = request('cfid',null);
        $pdata['video'] = trim($pdata['video'])!=null?trim($pdata['video']):'';
        $pdata['pic'] = trim($pdata['pic'])!=null?trim($pdata['pic']):'';
        $validator = Validator::make($pdata,[
            'platform_type'=>'required',
            'asin'=>'required',
//            'is_direct'=>'required|integer',
            'cfid'=>'integer',
            'star'=>'required|integer',

            'title'=>'required|max:64',
            'content'=>'required|max:1000',

            'start_time'=>'required|date_format:Y-m-d H:i|after:today',

        ]);
        if($validator->fails()){
            foreach($validator->errors()->getMessages() as $k=>$v){
                p($k.'=>'.$v[0]);
            }
            die;
        }
        $model = new Evaluate;
        $model->uid = Auth::user()->id;
        $model->shop_id = Auth::user()->shop_id;
        $model->platform_type = $pdata['platform_type'];
        $model->asin = $pdata['asin'];
        if($pdata['cfid'] != 0){
            $model->cfid = $pdata['cfid'];
        }
        $model->star = $pdata['star'];
        $model->title = $pdata['title'];
        $model->content = $pdata['content'];
        $model->start_time = $pdata['start_time'];
        $model->pic = $pdata['pic'];
        $model->video = $pdata['video'];
        $model->amount = get_amount_evaluate($pdata);
        $model->orderid = get_order_id();
        $model->save();

        return redirect('evaluatelist');
    }

    /**
     * 运行环境信息
     */
    public function getInfo(){
        phpinfo();
    }

    /**
     * get
     * 充值
     */
    public function getRecharge(){
        return view('pay.recharge');
    }

    /**
     * post
     * 充值
     */
    public function postRecharge(){
        $pdata = request()->all();
        $validator = Validator::make($pdata,[
            'name'=>'required|min:1|max:6',
            'mobile'=>'required|regex:/^1[345789][0-9]{9}/',
            'orderid'=>'required|integer',
            'amount'=>'required|numeric|min:1',
            'recharge_time'=>'required|date_format:Y-m-d H:i',
        ]);
        if($validator->fails()){
            foreach($validator->errors()->getMessages() as $k=>$v){
                p($k.'=>'.$v[0]);
            }
            die;
        }
        $model = new Recharge;
        $model->uid = Auth::user()->id;
        $model->name = $pdata['name'];
        $model->mobile = $pdata['mobile'];
        $model->orderid = $pdata['orderid'];
        $model->amount = $pdata['amount'];
        $model->recharge_time = $pdata['recharge_time'];
        $model->save();

        return redirect('recharge')->with('status','充值成功');
    }

    /**
     * list
     * 充值
     */
    public function listRecharge(){
        $list = Recharge::where('uid',Auth::user()->id)->orderBy('id','desc')->paginate(10);
        return view('pay.list_recharge')->with('tname','充值记录列表')->with('list',$list);
    }

    public function postCancle(){
        $id = request('id',0);
        $table = request('type','');
        if(!in_array($table,['click_farms','evaluates'])){
            return error(MODEL_NOT_FOUNT);
        }
        $model = DB::table($table)->find($id);
        if(!$model){
            return error(MODEL_NOT_FOUNT);
        }
        if($model->uid != Auth::user()->id){
            return error(NO_ACCESS);
        }
        if($model->status != 1){
            return error(NO_ACCESS);
        }

        DB::table($table)->where('id',$id)->update(['status'=>0]);

        return success();
    }

    public function postPay(){
        $id = request('id',0);
        $table = request('type','');
        if(!in_array($table,['click_farms','evaluates'])){
            return error(MODEL_NOT_FOUNT);
        }
        $model = DB::table($table)->find($id);
        if(!$model){
            return error(MODEL_NOT_FOUNT);
        }
        $uid = Auth::user()->id;
        if($model->uid != $uid){
            return error(NO_ACCESS);
        }
        if($model->status != 1){
            return error(NO_ACCESS);
        }
        $amount = Auth::user()->amount;
        if( $amount < $model->amount){
            return error(NO_ENOUGH_MONEY);
        }
        switch ($table){
            case 'click_farms':
                $type = 2;
                break;
            case 'evaluates':
                $type = 3;
                break;
        }
        $money = $amount - $model->amount;

        DB::beginTransaction();
        try{
            DB::table('users')->where('id',$uid)->update(['amount'=>$money]);
//            DB::table('users')->where('id',$uid)->decrement('amount',$model->amount);
            if(DB::table($table)->where('id',$id)->value('status') != 1){
                throw new Exception();
            }

            Bill::create([
                'uid'=>$uid,
                'type'=>$type,
                'orderid'=>$model->orderid,
                'out'=>$model->amount,
                'amount'=>$money,
                'taskid'=>$model->id
            ]);
            DB::table($table)->where('id',$id)->update(['status'=>2]);
            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
            return error(ERROR_IDEMPOTENCE);
        }

        return success();
    }

    /**
     * 流水账单
     */
    public function listBill(){
        $start = request('start');
        $end = request('end');
        $type = request('type',0);

        $table = Bill::where('uid',Auth::user()->id);
        if($start != null && $end != null){
            $table->whereBetween('created_at', [$start, $end]);
        }

        if($type){
           $table->where('type',$type);
        }
        $list = $table->orderBy('id','desc')->paginate(10);
        return view('pay.list_bill')->with('tname','账单列表')->with('list',$list)->with([
            'start'=>$start,
            'end'=>$end,
            'type'=>$type
        ]);
    }


    public function billDesc(){
        $type = request('type');
        $taskid = request('taskid');

        switch ($type){
            case 1:
                return redirect('viewrecharge/'.$taskid);
            case 2:
                return redirect('viewclickfarm/'.$taskid);
            case 3:
                return redirect('viewevaluate/'.$taskid);
            default:
                throw new Exception();
        }
    }

}