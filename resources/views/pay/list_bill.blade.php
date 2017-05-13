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

                        <form class="form-inline margin-bottom-30" action="{{url('billlist')}}" method="post">
                            {{csrf_field()}}
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
                typec: JSON.parse('{!! json_encode(App\Bill::OUT_TEXT) !!}'),
            },

        })
    </script>
@endsection