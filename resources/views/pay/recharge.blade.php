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
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">充值页面</div>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('recharge/pay') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 充值方式</label>
                                <div class="col-md-6">
                                    <label class="radio-inline" v-for="(v,k) in typec">
                                        <input type="radio" v-model="type" name="type" :value="k" required>@{{ v }}
                                    </label>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 充值金额</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="number" placeholder="" class="form-control" step="100" min="100" max="999999" maxlength="6" name="amount" v-model="amount" required>
                                        <div class="input-group-addon">元</div>
                                    </div>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label"> 金币</label>
                                <label class="col-md-6 control-label" v-text="getgolds"></label>
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
        $(function () {
            $('#recharge_time').datetimepicker({
                format: 'yyyy-mm-dd hh:ii',
                language:'zh-CN',
                autoclose:true,
                todayHighlight: 1,
            });
        })
        new Vue({
            el: '#app',
            data:{
                type:'1',
                amount:{{gconfig('cost.vip')}},
                rate:{{gconfig('rmbtogold')}},
                typec: {!! json_encode(config('linepro.order_ptypec')) !!},
            },
            computed:{
                getgolds(){
                    return (this.amount * this.rate).toFixed(0)
                }
            }
        })
    </script>
@endsection


