@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">{{$tname}}</div>
                    <div class="panel-body">

                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>时间</th>
                                <th>类型</th>
                                <th>获得</th>
                                <th>使用</th>
                                <th>剩余</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($list as $v)
                                <tr>
                                    <td>{{$v->id}}</td>
                                    <td>{{$v->created_at}}</td>
                                    <td>{{$v->type_text}}</td>
                                    <td :class="{'color-red': {{$v->in}}>0}">+ {{$v->in}}</td>
                                    <td :class="{'color-green': {{$v->out}}>0}">- {{$v->out}}</td>
                                    <td>{{$v->quota}}</td>
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
            },

        })
    </script>
@endsection