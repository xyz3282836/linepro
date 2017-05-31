@extends('layouts.app')
@section('css')
    <style>

    </style>
@endsection

@section('jslib')
@endsection


@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{$tname}}</div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>ASIN</th>
                            <th>亚马逊商品标题</th>
                            <th>商品图片</th>
                            <th>商铺ID</th>
                            <th>送货地址</th>
                            <th>单价</th>
                            <th>商品数量</th>
                            <th>当时汇率</th>
                            <th>总价</th>
                            <th>时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($list as $v)
                        <tr>
                            <td>{{$v->id}}</td>
                            <td>{{$v->asin}}</td>
                            <td><a href="{{$v->amazon_url}}">{{$v->amazon_title}}</a></td>
                            <td><a href="{{$v->amazon_pic}}"><img src="{{$v->amazon_pic}}" width="50" alt=""></a></td>
                            <td>{{$v->shop_id}}</td>
                            <td>{{$v->delivery_addr}}</td>
                            <td>{{$v->final_price}}</td>
                            <td>{{$v->task_num}}</td>
                            <td>{{$v->us_exchange_rate}}</td>
                            <td>{{$v->amount}}</td>
                            <td>{{$v->created_at}}</td>
                            <td>
                                @if($v->status == 1)
                                <button class="btn btn-danger btn-sm ladda-button" data-style="contract" @click="cancle({{$v->id}})">取消订单</button>
                                <button class="btn btn-success btn-sm ladda-button" data-style="contract" @click="pay({{$v->id}})">支付下单</button>
                                @elseif($v->status > 1)
                                    <a href="{{url('viewclickfarm/'.$v->id)}}">查看详情</a>
                                @endif
                            </td>
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
                axios.post("{{url('pay')}}",{type:'cf',id:id}).then(function (d) {
                    var data = d.data;
                    if(!data.code){
                        layer.msg(data.msg, {icon: 2});
                    }else{
                        layer.msg('支付成功', {icon: 1});
                        window.location.reload()
                    }
                })
            },
            cancle:function (id) {
                axios.post("{{url('canclecf')}}",{id:id}).then(function (d) {
                    var data = d.data;
                    if(!data.code){
                        layer.msg(data.msg, {icon: 2});
                    }else{
                        layer.msg('操作成功', {icon: 1});
                        window.location.reload()
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