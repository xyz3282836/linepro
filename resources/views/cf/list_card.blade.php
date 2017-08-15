@extends('layouts.app')
@section('css')
    <style type="text/css">
        .ad{
            width: 500px;
            height: 42px;
            position: absolute;
            padding: 10px;
            display: flex;
            align-items:center;
            justify-content: center;
            right: 15px;
        }
        .ad img{
            width: 500px;
            height: 42px;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="ad">
                        <a href="{{$ad['link']}}"><img src="{{$ad['pic']}}" alt=""></a>
                    </div>
                    <div class="panel-heading">{{$tname}}</div>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" :checked="allc" @click="selectall">全选
                                        </label>
                                    </div>
                                </th>
                                <th>商品图片</th>
                                <th>ASIN</th>
                                <th>亚马逊商品标题</th>
                                <th>商铺名称</th>
                                <th>站点</th>
                                <th>配送方式</th>
                                <th>送货地址</th>
                                <th>下单方式</th>
                                <th>单价</th>
                                <th>数量</th>
                                <th>当时汇率</th>
                                <th>手续费<img width="18" src="/img/gold.png" /></th>
                                <th>国内转运费</th>
                                <th>合计总价</th>
                                <th>订单生成时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="one in cardlist">
                                <td>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" v-model="ids" :value="one.id" @click="selectone">
                                        </label>
                                    </div>
                                </td>
                                <td><a :href="one.amazon_pic"><img :src="one.amazon_pic" width="100" alt=""></a></td>
                                <td v-text="one.asin"></td>
                                <td class="limit"><a :href="one.amazon_url" v-text="one.amazon_title"></a></td>
                                <td v-text="one.shop_id"></td>
                                <td v-text="one.from_site_text"></td>
                                <td v-text="one.delivery_type_text"></td>
                                <td v-text="one.delivery_addr"></td>
                                <td v-text="one.time_type_text"></td>
                                <td v-text="one.final_price_text"></td>
                                <td v-text="one.task_num"></td>
                                <td v-text="one.rate"></td>
                                <td v-text="one.golds">G</td>
                                <td v-text="one.transport">元</td>
                                <td v-text="one.amount">元</td>
                                <td v-text="one.created_at"></td>
                                <td>
                                    <button v-if="one.status == 1" class="btn btn-danger btn-sm ladda-button"
                                            data-style="contract" @click="cancle(one.id)">删除代购商品
                                    </button>
                                    <button v-if="one.status == 1" class="btn btn-success btn-sm ladda-button"
                                            data-style="contract" @click="pay(one.id)">立刻购买
                                    </button>
                                    <a v-if="one.status > 1" :href="'viewclickfarm/'+one.id">查看详情</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="pull-right">
                            <p>总金币：<span class="color-red" v-text="allgold"></span> G</p>
                            <p>总价格：<span class="color-red" v-text="allprice"></span> 元</p>

                            <button :disabled="ids.length == 0" class="btn btn-danger btn-md ladda-button"
                                    data-style="contract" @click="payall">支付下单
                            </button>
                        </div>
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
            data: {
                cardlist:{!! $list !!},
                allgold: 0,
                allprice: 0,
                allc: false,
                ids: [],
                allids: []
            },
            methods: {
                payall: function () {
                    axios.post("{{url('pay')}}", {id: this.ids}).then(function (d) {
                        var data = d.data;
                        if (!data.code) {
                            layer.msg(data.msg, {icon: 2});
                        } else {
                            layer.msg('操作成功', {icon: 1});
                            window.location.href = data.data;
                        }
                    })
                },
                pay: function (id) {
                    axios.post("{{url('pay')}}", {id: [id]}).then(function (d) {
                        var data = d.data;
                        if (!data.code) {
                            layer.msg(data.msg, {icon: 2});
                        } else {
                            layer.msg('操作成功', {icon: 1});
                            window.location.href = data.data;
                        }
                    })
                },
                cancle: function (id) {
                    axios.post("{{url('canclecf')}}", {id: id}).then(function (d) {
                        var data = d.data;
                        if (!data.code) {
                            layer.msg(data.msg, {icon: 2});
                        } else {
                            layer.msg('操作成功', {icon: 1});
                            window.location.reload()
                        }
                    })
                },
                selectone(){
                    console.log(this.ids)
                    this.getAll()
                },
                selectall(){
                    this.allc = !this.allc;
                    this.allc ? this.ids = this.allids : this.ids = []
                    this.getAll();
                },
                getAll(){
                    this.allgold = 0;
                    this.allprice = 0.00;
                    this.cardlist.forEach((v) => {
                        if (this.ids.indexOf(v.id) > -1) {
                            this.allgold += v.golds;
                            this.allprice += Number(v.amount);
                        }
                    });
                    this.allprice = this.allprice.toFixed(2)
                }
            },
            mounted: function () {
                this.$nextTick(() =>
                    this.cardlist.forEach((v, k) => {
                        this.allids.push(v.id)
                    }))
            }
        });
    </script>
@endsection