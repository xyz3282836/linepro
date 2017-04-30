@extends('layouts.app')
@section('csslib')
    {{--<link href="{{URL::asset('bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">--}}
    <link href="https://cdn.bootcss.com/bootstrap-datepicker/1.7.0-RC2/css/bootstrap-datepicker.min.css" rel="stylesheet">
@endsection

@section('jslib')
    <script src="https://cdn.bootcss.com/bootstrap-datepicker/1.7.0-RC2/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap-datepicker/1.7.0-RC2/locales/bootstrap-datepicker.zh-CN.min.js"></script>

    {{--<script src="{{URL::asset('bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>--}}
    {{--<script src="{{URL::asset('bootstrap-datetimepicker/js/bootstrap-datetimepicker.zh-CN.js')}}"></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>--}}
@endsection
@section('css')
    <style type="text/css">
        .margin-bottom-30{
            margin-bottom: 30px;
        }
    </style>
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
                                    <option value="0">综合</option>
                                    <option value="1">充值</option>
                                    <option value="2">刷单任务</option>
                                    <option value="3">评价任务</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary ladda-button" data-style="contract">查询</button>
                        </form>

                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>时间</th>
                                <th>类型</th>
                                <th>相关订单号</th>
                                <th>收入</th>
                                <th>支出</th>
                                <th>余额</th>
                                <th>详情</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($list as $v)
                                <tr>
                                    <td>{{$v->id}}</td>
                                    <td>{{$v->created_at}}</td>
                                    <td>{{$v->type_text}}</td>
                                    <td>{{$v->orderid}}</td>
                                    <td>+ {{$v->in}}</td>
                                    <td>- {{$v->out}}</td>
                                    <td>{{$v->amount}}</td>
                                    <td><a href="{{url('getbilldesc?type='.$v->type.'&taskid='.$v->taskid)}}">查看</a></td>
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
                type:"{{$type}}"
            },

        })
    </script>
@endsection