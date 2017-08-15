@extends('layouts.app')
@section('csslib')
    <link href="https://cdn.bootcss.com/bootstrap-datepicker/1.7.0-RC2/css/bootstrap-datepicker.min.css" rel="stylesheet">
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

                        <form class="form-inline margin-bottom-30" action="{{url('billlist')}}" method="get">
                            <div class="form-group">
                                <div class="input-daterange input-group" id="datepicker">
                                    <input type="text" class="form-control" name="start" value="{{$start}}" />
                                    <span class="input-group-addon">to</span>
                                    <input type="text" class="form-control" name="end" value="{{$end}}" />
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
                                <th>类型</th>
                                <th>订单号</th>
                                <th>支付宝订单号</th>
                                <th>人民币收入</th>
                                <th>人民币支出</th>
                                <th>金币收入</th>
                                <th>金币支出</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($list as $v)
                                <tr>
                                    <td>{{$v->id}}</td>
                                    <td>{{$v->created_at}}</td>
                                    <td>{{$v->type_text}}</td>
                                    <td>{{$v->orderid}}</td>
                                    <td>{{$v->alipay_orderid}}</td>
                                    <td :class="{'color-red': {{$v->in}}>0.00}">+ {{$v->in}}</td>
                                    <td :class="{'color-green': {{$v->out}}>0.00}">- {{$v->out}}</td>
                                    <td :class="{'color-red': {{$v->gin}}>0.00}">+ {{$v->gin}}</td>
                                    <td :class="{'color-green': {{$v->gout}}>0.00}">- {{$v->gout}}</td>
                                </tr>
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
        $(function(){
            $('.input-daterange').datepicker({
                format: 'yyyy-mm-dd',
                language:'zh-CN',
                autoclose:true,
                todayHighlight: true,
            });
        });
        new Vue({
            el: '#app',
            data:{
                type:"{{$type}}",
                typec: {!! json_encode(config('linepro.bill_types')) !!}
            },

        })
    </script>
@endsection