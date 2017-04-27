@extends('layouts.app')

@section('css')
    <style type="text/css">

    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">刷单任务列表</div>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>订单号</th>
                                    <th>消费金额</th>
                                    <th>时间</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($list as $v)
                                <tr>
                                    <td>{{$v->id}}</td>
                                    <td>{{$v->orderid}}</td>
                                    <td>{{$v->amount}}</td>
                                    <td>{{$v->created_at}}</td>
                                    <td><a href="{{url('viewclickfarm/'.$v->id)}}">查看</a></td>
                                </tr>
                                @empty
                                 <tr>
                                     <td colspan="5">no data</td>
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
