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
        table .limit{
            text-align: left;
            height: 120px;
            line-height: 30px;

            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
        }
        .breadcrumb{
            margin-bottom: 0;
        }
    </style>
@endsection
@section('csslib')
    <link href="{{url('flagicon/css/flag-icon.min.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="ad">
                        <a href="{{$ad['link']}}"><img src="{{$ad['pic']}}" alt=""></a>
                    </div>
                    <ol class="breadcrumb">
                        <li><a href="/">首页</a></li>
                        <li class="active">购物车</li>
                    </ol>
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
                                {{--<th>下单方式</th>--}}
                                <th>单价</th>
                                <th>数量</th>
                                <th>汇率</th>
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
                                <td>
                                    <div class="limit">
                                        <a :href="one.amazon_url" v-text="one.amazon_title"></a>
                                    </div>
                                </td>
                                <td v-text="one.shop_id"></td>
                                <td><span class="flag-icon" :class="'flag-icon-'+one.flag"></span></td>
                                <td v-text="one.delivery_type_text"></td>
                                <td v-text="one.delivery_addr"></td>
                                {{--<td v-text="one.time_type_text"></td>--}}
                                <td v-text="one.final_price_text"></td>
                                <td v-text="one.task_num"></td>
                                <td v-text="one.rate"></td>
                                <td v-text="one.golds">G</td>
                                <td v-text="one.transport">元</td>
                                <td v-text="one.amount">元</td>
                                <td v-text="one.created_at"></td>
                                <td>
                                    <button v-if="one.status == 1" class="btn btn-danger btn-sm ladda-button"
                                            data-style="contract" @click="cancle(one.id)">删除
                                    </button>
                                    <button v-if="one.status == 1" class="btn btn-success btn-sm ladda-button"
                                            data-style="contract" @click="pay(one.id)">购买
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="cardlist.length == 0">
                                <td colspan="99">暂无数据</td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="pull-right">
                            <div class="col-xs-6">
                                <p>总金币：<span class="color-red" v-text="allgold"></span> <img width="18" src="/img/gold.png" /></p>
                                <p>抵扣金币：<span class="color-red" v-text="payg"></span> <img width="18" src="/img/gold.png" /></p>
                                <p>需要充值：<span class="color-red" v-text="needPay"></span> 元</p>
                            </div>
                            <div class="col-xs-6">
                                <p>总价格：<span class="color-red" v-text="allprice"></span> 元</p>
                                <p>抵扣余额：<span class="color-red" v-text="rmb"></span> 元</p>
                                <p>待支付：<span class="color-red" v-text="needRmb"></span> 元</p>

                            </div>
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
                grate:{{gconfig('rmbtogold')}},
                cardlist:{!! $list !!},
                allgold: 0,
                allprice: 0,
                allc: false,
                ids: [],
                allids: [],
                deduction_gold: {{Auth::user()->golds - Auth::user()->lock_golds}},
                deduction_balance: {{Auth::user()->balance - Auth::user()->lock_balance}},
            },
            methods: {
                payall: function () {
                    var ids = this.ids;
                    layer.confirm('确定支付？', {
                        btn: ['是','再想想'],
                        closeBtn: 0
                    }, function(index){
                        layer.close(index);
                        axios.post("{{url('pay')}}", {id: ids}).then(function (d) {
                            var data = d.data;
                            if (!data.code) {
                                layer.msg(data.msg, {icon: 2});
                            } else {
                                layer.msg('操作成功', {icon: 1});
                                if(data.data == ''){
                                    window.location.href = "{{url('orderlist')}}";
                                }else{
                                    layer.confirm('即将前往支付包扫描付款？', {
                                        btn: ['是'],
                                        closeBtn: 0
                                    }, function(index){
                                        layer.close(index);
                                        window.open('/jumppay?id='+ data.data)
                                        layer.confirm('支付完成？', {
                                            btn: ['已完成支付','支付遇到问题'],
                                            closeBtn: 0
                                        }, function(index){
                                            close(index);
                                            window.location.href = "{{url('orderlist')}}";
                                        }, function(index){
                                            close(index);
                                            layer.msg('请联系管理员')
                                            window.location.href = "{{url('orderlist')}}";
                                        });
                                    });
                                }
                            }
                        })
                    }, function(index){
                        layer.close(index);
                    });
                },
                pay: function (id) {
                    layer.confirm('确定支付？', {
                        btn: ['是','再想想'],
                        closeBtn: 0
                    }, function(index){
                        layer.close(index);
                        axios.post("{{url('pay')}}", {id: [id]}).then(function (d) {
                            var data = d.data;
                            if (!data.code) {
                                layer.msg(data.msg, {icon: 2});
                            } else {
                                layer.msg('操作成功', {icon: 1});
                                if(data.data == ''){
                                    window.location.href = "{{url('orderlist')}}";
                                }else{
                                    layer.confirm('即将前往支付包扫描付款？', {
                                        btn: ['是'],
                                        closeBtn: 0
                                    }, function(index){
                                        layer.close(index);
                                        window.open('/jumppay?id='+ data.data)
                                        layer.confirm('支付完成？', {
                                            btn: ['已完成支付','支付遇到问题'],
                                            closeBtn: 0
                                        }, function(index){
                                            close(index);
                                            window.location.href = "{{url('orderlist')}}";
                                        }, function(index){
                                            close(index);
                                            layer.msg('请联系管理员')
                                            window.location.href = "{{url('orderlist')}}";
                                        });
                                    });
                                }
                            }
                        });
                    }, function(index){
                        layer.close(index);
                    });
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
                },
            },
            computed:{
                payg(){
                    if(this.deduction_gold >= this.allgold){
                        return this.allgold;
                    }else{
                        return this.deduction_gold;
                    }
                },
                rmb(){
                    if(this.deduction_balance >= this.allprice){
                        return this.allprice;
                    }else{
                        return this.deduction_balance;
                    }
                },
                needPay(){
                    return ((this.allgold - this.payg)/this.grate).toFixed(2);
                },
                needRmb(){
                    return (this.allprice - this.rmb).toFixed(2);
                }
            },
            mounted: function () {
                this.$nextTick(() => {
                    this.cardlist.forEach((v, k) => {
                        this.allids.push(v.id)
                        })
                    }
                )

            }
        });
    </script>
@endsection