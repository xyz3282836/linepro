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
                                <th>id</th>
                                <th>订单号</th>
                                <th>消费金额</th>
                                <th>状态</th>
                                <th>时间</th>
                                <th>操作</th>
                                <th>详情</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($list as $v)
                                <tr>
                                    <td>{{$v->id}}</td>
                                    <td>{{$v->orderid}}</td>
                                    <td>{{$v->amount}}</td>
                                    <td>{{$v->status_text}}</td>
                                    <td>{{$v->created_at}}</td>
                                    <td>
                                        @if($v->status == 1)
                                            <button class="btn btn-danger btn-sm ladda-button" data-style="contract" @click="cancle({{$v->id}})">取消订单</button>
                                            <button class="btn btn-success btn-sm ladda-button" data-style="contract" @click="pay({{$v->id}})">支付</button>
                                        @endif
                                    </td>
                                    <td><a href="{{url('viewevaluate/'.$v->id)}}">查看</a></td>
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
@section('js')
    <script>
        new Vue({
            el: '#app',
            methods: {
                pay:function (id) {
                    axios.post('pay',{type:'evaluates',id:id}).then(function (d) {
                        var data = d.data;
                        if(!data.code){
                            layer.msg(data.msg, {icon: 2});
                        }else{
                            layer.msg('操作成功', {icon: 1});
                            window.location.reload()
                        }
                    })

                },
                cancle:function (id) {
                    axios.post('cancle',{type:'evaluates',id:id}).then(function (d) {
                        var data = d.data;
                        if(!data.code){
                            layer.msg(data.msg, {icon: 2});
                        }else{
                            layer.msg('操作成功', {icon: 1});
                        }
                    })
                }
            },
            mounted: function () {
                this.$nextTick(() => {
                })
            },
        });
    </script>
@endsection