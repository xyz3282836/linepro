@extends('layouts.app')

@section('csslib')
    <link href="{{URL::asset('bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
@endsection

@section('jslib')
    <script src="{{URL::asset('bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{URL::asset('bootstrap-datetimepicker/js/bootstrap-datetimepicker.zh-CN.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">添加代购任务</div>
                    <div class="panel-body">
                        <form class="form-horizontal" data-toggle="validator" role="form" method="POST" action="{{ url('addclickfarm') }}">
                            {{ csrf_field() }}
                            {{--asin--}}
                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 购买的ASIN</label>
                                <div class="col-md-6">
                                    <input readonly type="text" placeholder="" class="form-control" minlength="1" maxlength="24" name="asin" value="{{request('asin')}}" required>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            {{--url--}}
                            <div class="form-group {{ $errors->has('amazon_url') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 亚马逊产品url</label>
                                <div class="col-md-6">
                                    <input readonly type="URL" class="form-control" name="amazon_url" value="{{request('detailUrl')}}" required>
                                    <p class="help-block with-errors">{{ $errors->first('amazon_url') }}</p>
                                </div>
                            </div>

                            {{--pic--}}
                            <div class="form-group {{ $errors->has('amazon_pic') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 亚马逊产品图片url</label>
                                <div class="col-md-6">

                                    <input readonly type="URL" placeholder="" class="form-control" name="amazon_pic" value="{{request('picUrl')}}" required>
                                    <p class="help-block with-errors">{{ $errors->first('amazon_pic') }}</p>
                                    <img src="{{request('picUrl')}}" width="150" alt="">
                                </div>
                            </div>

                            {{--title--}}
                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 亚马逊产品title</label>
                                <div class="col-md-6">
                                    <input readonly type="text" placeholder="" minlength="2" maxlength="50" value="{{request('title')}}" class="form-control" name="amazon_title" required>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            {{--店铺id--}}
                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 店铺id</label>
                                <div class="col-md-6">
                                    <input readonly type="text" placeholder="" minlength="2" maxlength="50" value="{{request('shopId')}}" class="form-control" name="shop_id" required>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            {{--单价--}}
                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 最终价格(包含运费)</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input readonly type="number" step="0.01" placeholder="" required class="form-control" name="final_price" min="0" max="999999" v-model="finalprice">
                                        <div class="input-group-addon">美元</div>
                                    </div>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label"> 服务费</label>
                                <label class="col-md-6 control-label" v-text="exchange"></label>
                            </div>

                            {{--num--}}
                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 代购件数</label>
                                <div class="col-md-6">
                                    <input type="number" placeholder="" class="form-control" value="{{request('')}}" name="task_num" min="1" max="9999" v-model="task" required>
                                    <p class="help-block with-errors"></p>
                                </div>
                                <div class="col-md-2"><p class="color-red">共计 <span v-text="getprice"></span> 元</p></div>
                            </div>

                            {{--送货地址--}}
                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 送货地址</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="delivery_addr" v-model="delivery_addr" required>
                                        <option value="{{Auth::user()->shipping_addr}}">{{Auth::user()->shipping_addr}}</option>
                                        <option value="美国转运仓">美国转运仓</option>
                                    </select>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary ladda-button" data-style="contract">
                                        提交
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script>
        new Vue({
            el: '#app',
            methods:{

            },
            mounted: function () {
                this.$nextTick(()=>{
                })
            },
            computed:{
                getprice:function () {
                    var exchange = {{$base_exchange}};
                    var freight_exchange = {{$freight_exchange}};
                    var one = this.finalprice;
                    var rate = this.usexcrate.toFixed(1);
                    if(this.delivery_addr == '美国转运仓'){
                        exchange += freight_exchange;
                    }
                    var all = (one * rate + exchange) * Number(this.task);
                    all = all.toFixed(2);
                    return all;
                }
            },
            data: {
                exchange:{{$base_exchange}},
                finalprice:{{request('totalPrice')}},
                task:1,
                usexcrate:{{config('linepro.us_exchange_rate')}},
                delivery_addr:"{{Auth::user()->shipping_addr}}"
            }
        });

    </script>
@endsection