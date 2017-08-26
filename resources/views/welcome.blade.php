@extends('layouts.app')

@section('css')
    <style type="text/css">
        #download{
            position: absolute;
            right: 15%;
            bottom: -20px;
        }
        .text-center{
            text-align: center;
        }
        .vedio h1{
            margin-bottom: 40px;
        }
        footer{
            min-height: 100px;
        }
        .navbar {
            margin-bottom: 0;
        }
    </style>
@endsection


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div id="dg-carousel" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    @foreach(App\Banner::getBanners() as $k=>$v)
                        <li data-target="#dg-carousel" data-slide-to="{{$k}}" class="@if($k == 0) active @endif"></li>
                    @endforeach
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    @foreach(App\Banner::getBanners() as $k=>$v)
                        <div class="item @if($k == 0) active @endif">
                            <img src="{{$v['pic']}}" alt="">
                            <div class="carousel-caption">

                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Controls -->
                <a class="left carousel-control" href="#dg-carousel" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#dg-carousel" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>

                <a id="download" class="btn btn-danger btn-lg" href="http://pan.baidu.com/s/1kVQh1eZ" target="_blank"><i class="fa fa-download" aria-hidden="true"></i> 立即下载</a>
            </div>
        </div>
    </div>
    <div class="container vedio">
        <div class="row">
            <div class="col-xs-12">
                <h1 class="text-center">一分钟快速入门，了解达购海淘</h1>
                <div class="text-center">
                    <iframe height=400 width=480 src='{{gconfig('broadcast.video')}}' frameborder=0 'allowfullscreen'></iframe>
                </div>
            </div>
        </div>
    </div>
    <footer class="container">
        <div class="row">
            <div class="col-xs-12">

            </div>
        </div>
    </footer>
@endsection