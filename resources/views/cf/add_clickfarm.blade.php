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
                    <div class="panel-heading">添加刷单任务</div>
                    <div class="panel-body">
                        <form class="form-horizontal" data-toggle="validator" role="form" method="POST" action="{{ url('addclickfarm') }}">
                            {{ csrf_field() }}

                            {{--asin--}}
                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 购买的ASIN</label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="" class="form-control" minlength="1" maxlength="24" name="asin" value="{{old('asin')}}" required>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            {{--url--}}
                            <div class="form-group {{ $errors->has('amazon_url') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 亚马逊产品url</label>
                                <div class="col-md-6">
                                    <input type="URL" class="form-control" name="amazon_url" value="{{old('amazon_url')}}" required>
                                    <p class="help-block with-errors">{{ $errors->first('amazon_url') }}</p>
                                </div>
                            </div>

                            {{--pic--}}
                            <div class="form-group {{ $errors->has('amazon_pic') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 亚马逊产品图片url</label>
                                <div class="col-md-6">
                                    <input type="URL" placeholder="" class="form-control" name="amazon_pic" value="{{old('amazon_pic')}}" required>
                                    <p class="help-block with-errors">{{ $errors->first('amazon_pic') }}</p>
                                </div>
                            </div>

                            {{--title--}}
                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 亚马逊产品title</label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="" minlength="2" maxlength="50" value="{{old('amazon_title')}}" class="form-control" name="amazon_title" required>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            {{--店铺id--}}
                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 店铺id</label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="" minlength="2" maxlength="50" value="{{old('shop_id')}}" class="form-control" name="shop_id" required>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            {{--单价--}}
                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 最终价格(包含运费)</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="number" step="0.01" placeholder="" required class="form-control" name="final_price" min="0" max="999999" v-model="finalprice">
                                        <div class="input-group-addon">美元</div>
                                    </div>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            {{--num--}}
                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 刷单件数</label>
                                <div class="col-md-6">
                                    <input type="number" placeholder="" class="form-control" value="{{old('task_num')}}" name="task_num" min="1" max="9999" v-model="task" required>
                                    <p class="help-block with-errors"></p>
                                </div>
                                <div class="col-md-2"><p class="color-red">共计 <span v-text="getprice"></span> 元</p></div>
                            </div>

                            {{--送货地址--}}
                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 送货地址</label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="" minlength="2" value="{{old('delivery_addr')}}" maxlength="50" class="form-control" name="delivery_addr" required>
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
                    var one = this.finalprice;
                    var all = (one*this.usexcrate + {{config('linepro.clickfarm_price.service_charge')}})*Number(this.task);
                    all = all.toFixed(2);
                    return all;
                }
            },
            data: {
                finalprice:{{old('final_price')}},
                task:1,
                usexcrate:{{config('linepro.us_exchange_rate')}}
            }
        });

    </script>
@endsection