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
                                <label class="col-md-4 control-label">充值状态</label>
                                <label class="col-md-6 control-label">{{$one->status_text}}</label>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">充值类型</label>
                                <label class="col-md-6 control-label">{{$one->type_text}}</label>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">充值订单</label>
                                <label class="col-md-6 control-label">{{$one->orderid}}</label>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">支付宝订单</label>
                                <label class="col-md-6 control-label">{{$one->alipay_orderid}}</label>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">金额</label>
                                <label class="col-md-6 control-label">{{$one->amount}}</label>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">充值时间</label>
                                <label class="col-md-6 control-label">{{$one->created_at}}</label>
                            </div>

                            @if($one->status == 1)
                            <div class="form-group">
                                <label class="col-md-4 control-label">到账时间</label>
                                <label class="col-md-6 control-label">{{$one->updated_at}}</label>
                            </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection