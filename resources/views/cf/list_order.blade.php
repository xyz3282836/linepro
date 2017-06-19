@extends('layouts.app')
@section('csslib')
    <link href="https://cdn.bootcss.com/bootstrap-datepicker/1.7.0-RC2/css/bootstrap-datepicker.min.css"
          rel="stylesheet">
@endsection

@section('jslib')
    <script src="https://cdn.bootcss.com/bootstrap-datepicker/1.7.0-RC2/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap-datepicker/1.7.0-RC2/locales/bootstrap-datepicker.zh-CN.min.js"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">{{$tname}}</div>
                    <div class="panel-body">

                        <form class="form-inline margin-bottom-30" action="{{url('orderlist')}}" method="get">
                            <div class="form-group">
                                <div class="input-daterange input-group" id="datepicker">
                                    <input type="text" class="form-control" name="start" value="{{$start}}"/>
                                    <span class="input-group-addon">to</span>
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
                                <th>类型</th>
                                <th>时间</th>
                                <th>订单号</th>
                                <th>总价</th>
                                <th>余额支出</th>
                                <th>充值支出</th>
                                <th>金币支出</th>
                                <th>详情</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($list as $v)
                                <tr>
                                    <td>{{$v->type_text}}</td>
                                    <td>{{$v->created_at}}</td>
                                    <td>{{$v->orderid}}</td>
                                    <td>{{$v->price}}</td>
                                    <td>{{$v->balance}}</td>
                                    <td>{{$v->price - $v->balance}}</td>
                                    <td>{{$v->golds}}</td>
                                    <td>
                                        <a v-if="{{$v->status}} == 1" href="{{url('jumppay?id='.$v->id)}}" class="btn btn-success btn-sm">支付订单</a>
                                    </td>
                                </tr>
                                @if($v->type == 2)
                                <tr>
                                    <td></td>
                                    <td colspan="99">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>商品标题</th>
                                                <th>商品数量</th>
                                                <th>转运费</th>
                                                <th>手续费</th>
                                                <th>合计总价</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($v->cfs as $vv)
                                                <tr>
                                                    <td><a href="{{$vv->amazon_url}}">{{$vv->amazon_title}}</a></td>
                                                    <td>{{$vv->task_num}}</td>
                                                    <td>{{$vv->transport}} 元</td>
                                                    <td>{{$vv->golds}} G</td>
                                                    <td>{{$vv->amount}} 元</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="99">no data</td>
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

        })
    </script>
@endsection