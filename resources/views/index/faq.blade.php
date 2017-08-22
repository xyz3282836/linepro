@extends('layouts.app')

@section('css')
    <style type="text/css">

    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="/">首页</a></li>
                    <li class="active">Faqs</li>
                </ol>
                @foreach($list as $v)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{$v['q']}}</h3>
                        </div>
                        <div class="panel-body">
                            {!! $v['a'] !!}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection