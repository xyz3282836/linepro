@extends('layouts.app')

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
                                <th>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox">全选
                                        </label>
                                    </div>
                                </th>
                                <th>ASIN</th>
                                <th>亚马逊商品标题</th>
                                <th>商品图片</th>
                                <th>商铺名称</th>
                                <th>站点</th>
                                <th>配送方式</th>
                                <th>送货地址</th>
                                <th>下单方式</th>
                                <th>单价</th>
                                <th>数量</th>
                                <th>当时汇率</th>
                                <th>手续费(G)</th>
                                <th>国内转运费</th>
                                <th>合计总价</th>
                                <th>订单生成时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($list as $v)
                                <tr>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="id" value="{{$v->id}}">
                                            </label>
                                        </div>
                                    </td>
                                    <td>{{$v->asin}}</td>
                                    <td><a href="{{$v->amazon_url}}">{{$v->amazon_title}}</a></td>
                                    <td><a href="{{$v->amazon_pic}}"><img src="{{$v->amazon_pic}}" width="50" alt=""></a></td>
                                    <td>{{$v->shop_id}}</td>
                                    <td>{{$v->from_site_text}}</td>
                                    <td>{{$v->delivery_type_text}}</td>
                                    <td>{{$v->delivery_addr}}</td>
                                    <td>{{$v->time_type_text}}</td>
                                    <td>{{$v->final_price}}({{get_currency($v->from_site)}})</td>
                                    <td>{{$v->task_num}}</td>
                                    <td>{{$v->rate}}</td>
                                    <td>{{$v->golds}}G</td>
                                    <td>{{$v->transport}}元</td>
                                    <td>{{$v->amount}}元</td>
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
    </script>
@endsection