@extends('layouts.app')
@section('csslib')
    <link href="https://cdn.bootcss.com/bootstrap-datepicker/1.7.0-RC2/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="{{url('flagicon/css/flag-icon.min.css')}}" rel="stylesheet">
@endsection

@section('jslib')
    <script src="https://cdn.bootcss.com/bootstrap-datepicker/1.7.0-RC2/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap-datepicker/1.7.0-RC2/locales/bootstrap-datepicker.zh-CN.min.js"></script>
@endsection
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
        .table .table {
            background-color: white;
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
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="/">首页</a></li>
                    <li class="active">订单管理</li>
                </ol>
                <div class="panel panel-default">
                    <div class="ad">
                        <a href="{{$ad['link']}}"><img src="{{$ad['pic']}}" alt=""></a>
                    </div>
                    <div class="panel-heading">{{$tname}}</div>
                    <div class="panel-body">
                        <form class="form-inline margin-bottom-30" action="{{url('orderlist')}}" method="get">
                            <div class="form-group">
                                <div class="input-daterange input-group" id="datepicker">
                                    <input type="text" class="form-control" name="start" value="{{$start}}"/>
                                    <span class="input-group-addon">-</span>
                                    <input type="text" class="form-control" name="end" value="{{$end}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <select class="form-control select-sm" name="type" required v-model="type">
                                    <option v-for="(v,k) in typec" v-text="v" :value="k"></option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary ladda-button" data-style="contract">查询</button>
                        </form>

                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>时间</th>
                                <th>订单号</th>
                                <th>总价</th>
                                <th>余额支出</th>
                                <th>充值支出</th>
                                <th>金币支出</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($list as $v)
                                <tr>
                                    <td>{{$v->id}}</td>
                                    <td>{{$v->created_at}}</td>
                                    <td>{{$v->orderid}}</td>
                                    <td>{{$v->price}} 元</td>
                                    <td>{{$v->balance}} 元</td>
                                    <td>{{$v->pay}} 元</td>
                                    <td>{{$v->golds}} <img width="12" src="/img/gold.png" /></td>
                                    <td>
                                        @if($v->status == 1)
                                            <a href="javascript:;" @click="pay({{$v->id}})" class="btn btn-success btn-sm">支付订单</a>
                                            <button class="btn btn-danger btn-sm ladda-button"
                                                    data-style="contract" @click="del({{$v->id}})">取消订单
                                            </button>
                                        @else
                                            {{$v->status_text}}
                                        @endif

                                    </td>
                                </tr>
                                @if($v->type == 2)
                                <tr>
                                    <td></td>
                                    <td colspan="99">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>商品图片</th>
                                                <th>商品标题</th>
                                                <th>站点</th>
                                                {{--<th>下单方式</th>--}}
                                                <th>单价</th>
                                                <th>当前货币汇率</th>
                                                <th>商品数量</th>
                                                <th>转运费</th>
                                                <th>手续费率</th>
                                                <th>手续费</th>
                                                <th>合计总价</th>
                                                <th>操作</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($v->cfs as $vv)
                                                <tr>
                                                    <td><a href="{{$vv->amazon_pic}}"><img src="{{$vv->amazon_pic}}" width="100" alt=""></a></td>
                                                    <td>
                                                        <div class="limit">
                                                            <a href="{{$vv->amazon_url}}">{{$vv->amazon_title}}</a>
                                                        </div>
                                                    </td>
                                                    <td><span class="flag-icon flag-icon-{{App\ExchangeRate::getFlag($vv->from_site)}}"></span></td>
{{--                                                    <td>{{$vv->time_type_text}}</td>--}}
                                                    <td>{{$vv->final_price_text}}</td>
                                                    <td>{{$vv->rate}}</td>
                                                    <td>{{$vv->task_num}}</td>
                                                    <td>{{$vv->transport}} 元</td>
                                                    <td>{{$vv->srate * 100}} %</td>
                                                    <td>{{$vv->golds}} <img width="12" src="/img/gold.png" /></td>
                                                    <td>{{$vv->amount}} 元</td>
                                                    <td>
                                                        @if($v->status > 1)
                                                        <a class="btn btn-primary btn-sm" href="{{url('viewclickfarm/'.$vv->id)}}">详情</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="99">暂无数据</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        @if($list)
                            {!!  $list->appends(['start'=>$start,'end'=>$end,'type'=>$type])->links() !!}

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(function () {
            $('.input-daterange').datepicker({
                format: 'yyyy-mm-dd',
                language: 'zh-CN',
                autoclose: true,
                todayHighlight: true,
            });
        });
        new Vue({
            el: '#app',
            data: {
                type: "{{$type}}",
                typec: {!! json_encode(config('linepro.order_statuss')) !!}
            },
            methods:{
                del(id) {
                    axios.post("{{url('delorder')}}", {id: id}).then(function (d) {
                        var data = d.data;
                        if (!data.code) {
                            layer.msg(data.msg, {icon: 2});
                        } else {
                            layer.msg('操作成功', {icon: 1});
                            window.location.reload();
                        }
                    })
                },
                pay(id) {
                    openUrl('/jumppay?id='+ id);
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
                },
            }

        })
    </script>
@endsection