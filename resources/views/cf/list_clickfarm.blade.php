@extends('layouts.app')
@section('css')
    <style>

    </style>
@endsection
@section('csslib')
    <link href="https://cdn.bootcss.com/bootstrap-datepicker/1.7.0-RC2/css/bootstrap-datepicker.min.css" rel="stylesheet">
@endsection

@section('jslib')
    <script src="https://cdn.bootcss.com/bootstrap-datepicker/1.7.0-RC2/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap-datepicker/1.7.0-RC2/locales/bootstrap-datepicker.zh-CN.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>
@endsection


@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{$tname}}</div>
                <div class="panel-body">
                    <form class="form-inline margin-bottom-30" action="{{url('itemlist')}}" method="post">
                        {{csrf_field()}}

                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="ASIN" name="asin" value="{{$asin}}">
                        </div>
                        <div class="form-group">
                            <div class="input-daterange input-group" id="datepicker">
                                <input type="text" class="form-control" name="start" value="{{$start}}" />
                                <span class="input-group-addon">to</span>
                                <input type="text" class="form-control" name="end" value="{{$end}}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <select class="form-control select-sm" name="status" required v-model="status">
                                <option v-for="(v,k) in statusc" v-text="v" :value="k"></option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary ladda-button" data-style="contract">查询</button>
                    </form>
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
                        {!!  $list->appends(['asin'=>$asin,'start'=>$start,'end'=>$end,'status'=>$status])->links() !!}
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
        data:{
            statusc: JSON.parse('{!! json_encode(App\ClickFarm::getExceptText()) !!}'),
            status:'{{$status}}'
        },
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

    $(function () {
        $('.input-daterange').datepicker({
            format: 'yyyy-mm-dd',
            language:'zh-CN',
            autoclose:true,
            todayHighlight: true,
        });
    })
</script>
@endsection