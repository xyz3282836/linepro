@extends('layouts.app')

@section('css')
    <style type="text/css">

    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">{{$tname}}</div>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>充值单号</th>
                                <th>支付宝单号</th>
                                <th>充值金额</th>
                                <th>充值时间</th>
                                <th>充值类型</th>
                                <th>状态</th>
                                <th>反馈</th>
                                <th>详情</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($list as $v)
                                <tr>
                                    <td>{{$v->id}}</td>
                                    <td>{{$v->orderid}}</td>
                                    <td>{{$v->alipay_orderid}}</td>
                                    <td>{{$v->amount}}</td>
                                    <td>{{$v->created_at}}</td>
                                    <td>{{$v->type_text}}</td>
                                    <td>{{$v->status_text}}</td>
                                    <td>{{$v->feedback}}</td>
                                    <td><a href="{{url('viewrecharge/'.$v->id)}}">查看</a></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="99">no data</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        @if($list)
                            {!!  $list->links() !!}

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
