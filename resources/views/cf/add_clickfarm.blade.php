@extends('layouts.app')

@section('csslib')
    <link href="{{URL::asset('bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
@endsection

@section('css')
    <style type="text/css">
        .col-md-6.control-label,.col-md-1.control-label {
            text-align: left;
            font-size: 1.3em;
        }
        .col-md-1.control-label a{
            color: black;
        }
        .ad{
            width: 150px;
            height: 150px;
            position: fixed;
            padding: 10px;
            display: flex;
            align-items:center;
            justify-content: center;
        }
        .ad img{
            width: 150px;
            height: 150px;
        }
    </style>
@endsection

@section('jslib')
    <script src="{{URL::asset('bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{URL::asset('bootstrap-datetimepicker/js/bootstrap-datetimepicker.zh-CN.js')}}"></script>
    <script src="https://cdn.bootcss.com/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">添加代购任务</div>
                    <div class="panel-body">
                        <div class="ad">
                            <a href="{{$ad['link']}}"><img src="{{$ad['pic']}}" alt=""></a>
                        </div>
                        <form id="dgform" class="form-horizontal" data-toggle="validator" role="form" method="POST" action="{{ url('addclickfarm') }}">
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
                                <label class="col-md-4 control-label"><span class="color-red">*</span>
                                    亚马逊产品图片url</label>
                                <div class="col-md-6">

                                    <input readonly type="URL" placeholder="" class="form-control" name="amazon_pic" value="{{request('picUrl')}}" required>
                                    <p class="help-block with-errors">{{ $errors->first('amazon_pic') }}</p>
                                    <img src="{{request('picUrl')}}" width="150" alt="">
                                </div>
                            </div>

                            {{--title--}}
                            <div class="form-group {{ $errors->has('amazon_title') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label"><span class="color-red">*</span>
                                    亚马逊产品title</label>
                                <div class="col-md-6">
                                    <input readonly type="text" placeholder="" minlength="2" maxlength="50" value="{{request('title')}}" class="form-control" name="amazon_title" required>
                                    <p class="help-block with-errors">{{ $errors->first('amazon_title') }}</p>
                                </div>
                            </div>

                            {{--店铺id--}}
                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 店铺名称</label>
                                <div class="col-md-6">
                                    <input readonly type="text" placeholder="" maxlength="50" value="{{request('shopName')}}" class="form-control" name="shop_name" required>
                                    <input type="hidden" name="shop_id" value="{{request('shopId')}}">
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            {{--发货方式--}}
                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 发货方式</label>
                                <div class="col-md-6">
                                    <label class="radio-inline" v-for="(v,k) in is_fbac">
                                        <input disabled type="radio" v-model="is_fba" name="is_fba" :value="k">@{{ v }}
                                    </label>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            {{--单价--}}
                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span>
                                    最终价格(包含亚马逊运费)</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input readonly type="number" required class="form-control" name="final_price" min="0" max="999999" v-model="final_price">
                                        <input type="hidden" name="from_site" value="{{request('site')}}">
                                        <div class="input-group-addon">{{$ctext}}</div>
                                    </div>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            {{--<div class="form-group">--}}
                                {{--<label class="col-md-4 control-label"><span class="color-red">*</span> 下单方式</label>--}}
                                {{--<div class="col-md-6">--}}
                                    {{--<label class="radio-inline" v-for="(v,k) in time_typec">--}}
                                        {{--<input type="radio" v-model="time_type" name="time_type" :value="k" required>@{{ v }}--}}
                                    {{--</label>--}}
                                    {{--<p class="help-block with-errors"></p>--}}
                                {{--</div>--}}
                                {{--<label class="col-md-1 control-label">--}}
                                    {{--<a href="{{url('faqs')}}" target="_blank">?</a>--}}
                                {{--</label>--}}
                            {{--</div>--}}

                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 配送方式</label>
                                <div class="col-md-6">
                                    <label class="radio-inline" v-for="(v,k) in delivery_typec">
                                        <input type="radio" v-model="delivery_type" name="delivery_type" :value="k">@{{ v }}
                                    </label>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            <div class="form-group" v-show="delivery_type == 2">
                                <label class="col-md-4 control-label">国内转运地址</label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="" class="form-control" name="delivery_addr" maxlength="50" value="{{Auth::user()->shipping_addr}}">
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            {{--num--}}
                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 代购件数</label>
                                <div class="col-md-6">
                                    <input type="number" placeholder="" class="form-control" name="task_num" min="1" max="9999" v-model="task_num" required>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label"> 国内转运费</label>
                                <label class="col-md-6 control-label" v-text="gettrans"></label>
                                <label class="col-md-1 control-label">
                                    <a href="{{url('faqs')}}" target="_blank">?</a>
                                </label>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label"> 服务费(100<img src="/img/gold.png" />=1元)</label>
                                <label class="col-md-6 control-label" v-text="getservice"></label>
                                <label class="col-md-1 control-label">
                                    <a href="{{url('faqs')}}" target="_blank">?</a>
                                </label>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label"> 共计</label>
                                <label class="col-md-6 control-label" v-text="getall"></label>
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
        const APP = new Vue({
            el: '#app',
            methods: {},
            mounted: function () {
                this.$nextTick(()=>{

                })
            },
            computed: {
                getall: function () {
                    return (this.task_num * this.final_price * this.rate + this.alltrans).toFixed(2) + '元(商品原价×汇率×服务费费率+商品原价)';
                },
                getservice: function () {
                    var tmp = (this.task_num * this.final_price * this.rate * this.rmbtogold * this.srate[this.time_type].rate).toFixed(0);
                    tmp = tmp < Number(this.srate[this.time_type].mingolds) ? this.srate[this.time_type].mingolds : tmp
                    return tmp;
                },
                gettrans: function () {
                    this.delivery_type == 1 ? this.alltrans = 0 : this.alltrans = this.task_num * this.trans;
                    return this.alltrans.toFixed(2) + '元';
                }
            },
            data: {
                alltrans: 0,
                rate:{{$rate}},
                rmbtogold:{{$rmbtogold}},
                trans:{{$trans}},
                srate: {!! $srate !!},
                final_price:{{request('totalPrice')}},
                task_num: 1,
                time_type: 1,
                is_fba: {{request('isFba')}},
                is_fbac: {!! json_encode(config('linepro.is_fba')) !!},
                delivery_type: 1,
                delivery_typec: {!! json_encode(config('linepro.delivery_type')) !!},
            }
        });
        $('#dgform').validator().on('submit', function (e) {
           if(APP.is_fba == 0){
               layer.msg('本系统暂不支持非亚马逊发货海淘');
               return false;
           }
        })
    </script>
@endsection