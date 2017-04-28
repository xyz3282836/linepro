@extends('layouts.app')

@section('css')
    <style type="text/css">
        .col-md-6.control-label{
            text-align: left;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">充值详细信息</div>
                    <div class="panel-body">
                        <form class="form-horizontal">


                            <div class="form-group">
                                <label class="col-md-4 control-label">充值类型</label>
                                <label class="col-md-6 control-label">{{$one->type}}</label>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">充值时间</label>
                                <label class="col-md-6 control-label">{{$one->recharge_time}}</label>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">充值凭证</label>
                                <label class="col-md-6 control-label">{{$one->orderid}}</label>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">姓名</label>
                                <label class="col-md-6 control-label">{{$one->name}}</label>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">手机</label>
                                <label class="col-md-6 control-label">{{$one->mobile}}</label>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">金额</label>
                                <label class="col-md-6 control-label">{{$one->amount}}</label>
                            </div>



                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection