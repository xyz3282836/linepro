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
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">充值页面</div>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('recharge') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="col-md-4 control-label"> 支付宝二维码</label>
                                <div class="col-md-6">
                                    <img src="{{URL::asset('img/pay.png')}}" alt="">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 姓名</label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="" class="form-control" minlength="2" maxlength="6" name="name" required>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 手机号</label>
                                <div class="col-md-6">
                                    <input type="text" pattern="1[345789][0-9]{9}" placeholder="" class="form-control" minlength="11" maxlength="11" name="mobile" required>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 交易凭证号(订单号前八位)</label>
                                <div class="col-md-6">
                                    <input type="number" placeholder="" class="form-control" minlength="8" maxlength="8" name="orderid" required>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 充值金额</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="number" placeholder="" class="form-control" minlength="8" maxlength="8" name="amount" required>
                                        <div class="input-group-addon">元</div>
                                    </div>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 充值时间</label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="" class="form-control" name="recharge_time" id="recharge_time" required>
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
        $(function () {
            $('#recharge_time').datetimepicker({
                format: 'yyyy-mm-dd hh:ii',
                language:'zh-CN',
                autoclose:true,
                todayHighlight: 1,
            });
        })
    </script>
@endsection


