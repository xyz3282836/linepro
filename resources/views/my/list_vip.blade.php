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
                    <div class="panel-heading">{!! $tname !!}</div>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>会员有效天数</th>
                                <th>到期时间</th>
                                <th>充值时间</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($list as $v)
                                <tr>
                                    <td>{{$v->id}}</td>
                                    <td>{{$v->days}}</td>
                                    <td>{{$v->validity}}</td>
                                    <td>{{$v->created_at}}</td>
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
