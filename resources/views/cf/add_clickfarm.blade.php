@extends('layouts.app')

@section('csslib')
    <link href="{{URL::asset('bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
@endsection

@section('css')
    <style type="text/css">
        .col-md-6.control-label {
            text-align: left;
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
                        <form class="form-horizontal" data-toggle="validator" role="form" method="POST"
                              action="{{ url('addclickfarm') }}">
                            {{ csrf_field() }}
                            {{--asin--}}
                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 购买的ASIN</label>
                                <div class="col-md-6">
                                    <input readonly type="text" placeholder="" class="form-control" minlength="1"
                                           maxlength="24" name="asin" value="{{request('asin')}}" required>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            {{--url--}}
                            <div class="form-group {{ $errors->has('amazon_url') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 亚马逊产品url</label>
                                <div class="col-md-6">
                                    <input readonly type="URL" class="form-control" name="amazon_url"
                                           value="{{request('detailUrl')}}" required>
                                    <p class="help-block with-errors">{{ $errors->first('amazon_url') }}</p>
                                </div>
                            </div>

                            {{--pic--}}
                            <div class="form-group {{ $errors->has('amazon_pic') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label"><span class="color-red">*</span>
                                    亚马逊产品图片url</label>
                                <div class="col-md-6">

                                    <input readonly type="URL" placeholder="" class="form-control" name="amazon_pic"
                                           value="{{request('picUrl')}}" required>
                                    <p class="help-block with-errors">{{ $errors->first('amazon_pic') }}</p>
                                    <img src="{{request('picUrl')}}" width="150" alt="">
                                </div>
                            </div>

                            {{--title--}}
                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span>
                                    亚马逊产品title</label>
                                <div class="col-md-6">
                                    <input readonly type="text" placeholder="" minlength="2" maxlength="50"
                                           value="{{request('title')}}" class="form-control" name="amazon_title"
                                           required>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            {{--店铺id--}}
                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 店铺id</label>
                                <div class="col-md-6">
                                    <input readonly type="text" placeholder="" minlength="2" maxlength="50"
                                           value="{{request('shopId')}}" class="form-control" name="shop_id" required>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            {{--单价--}}
                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span>
                                    最终价格(包含运费)</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input readonly type="number" step="0.01" placeholder="" required
                                               class="form-control" name="final_price" min="0" max="999999"
                                               v-model="finalprice">
                                        <div class="input-group-addon">{{$ctext}}</div>
                                    </div>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 下单方式</label>
                                <div class="col-md-6">
                                    <label class="radio-inline" v-for="(v,k) in time_typec">
                                        <input type="radio" v-model="time_type" name="time_type" :value="k"
                                               required>@{{ v }}
                                    </label>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 配送方式</label>
                                <div class="col-md-6">
                                    <label class="radio-inline" v-for="(v,k) in delivery_typec">
                                        <input type="radio" v-model="delivery_type" name="delivery_type" :value="k"
                                               required>@{{ v }}
                                    </label>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            <div class="form-group" v-show="delivery_type == 2">
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="国内转运地址" class="form-control" name="delivery_addr"
                                           maxlength="50" value="{{Auth::user()->shipping_addr}}">
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            {{--num--}}
                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 代购件数</label>
                                <div class="col-md-6">
                                    <input type="number" placeholder="" class="form-control" name="task_num" min="1"
                                           max="9999" v-model="task_num" required>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label"> 转运费</label>
                                <label class="col-md-6 control-label" v-text="gettrans"></label>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label"> 服务费</label>
                                <label class="col-md-6 control-label" v-text="getservice"></label>
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
        new Vue({
            el: '#app',
            methods: {},
            mounted: function () {
                this.$nextTick(function () {

                    }
                )
            },
            computed: {
                getall: function () {
                    return (this.task_num * this.finalprice * this.rate + this.alltrans).toFixed(2) + '元';
                },
                getservice: function () {
                    var tmp = (this.task_num * this.finalprice * this.rate * 100 * this.srate[this.time_type].rate).toFixed(0);
                    tmp = tmp < Number(this.srate[this.time_type].mingolds) ? this.srate[this.time_type].mingolds : tmp
                    return tmp + 'G';
                },
                gettrans: function () {
                    this.delivery_type == 1 ? this.alltrans = 0 : this.alltrans = this.task_num * this.trans;
                    return this.alltrans.toFixed(2) + '元';
                },
            },
            data: {
                alltrans: 0,
                rate:{{$rate}},
                trans:{{$trans}},
                srate: JSON.parse('{!! $srate !!}'),
                finalprice:{{request('totalPrice')}},
                task_num: 1,
                time_type: 1,
                time_typec: JSON.parse('{!! json_encode(config('linepro.time_typec')) !!}'),
                delivery_type: 1,
                delivery_typec: JSON.parse('{!! json_encode(config('linepro.delivery_typec')) !!}'),
            }
        });

    </script>
@endsection