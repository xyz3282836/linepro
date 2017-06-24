<!DOCTYPE html>
<html lang="{{ gconfig('site.name') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ gconfig('site.name') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <style>
        .navbar-default {
            background-color: black;
        }
        .navbar-default .navbar-brand {
            color: white;
        }
        .navbar-brand,.navbar-brand img {
            padding: 0;
            height: 50px;
        }
        .navbar {
            margin-bottom: 0;
        }
        #download{
            position: absolute;
            right: 250px;
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
    </style>

</head>
<body>
<div id="app">

    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="javascript:;">
                    <img alt="Brand" height="50" src="https://zos.alipayobjects.com/rmsportal/ZBtrIlcNSvkudzvriZvZ.png">
                </a>
            </div>

        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div id="dg-carousel" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#dg-carousel" data-slide-to="0" class="active"></li>
                    <li data-target="#dg-carousel" data-slide-to="1"></li>
                    <li data-target="#dg-carousel" data-slide-to="2"></li>
                    <li data-target="#dg-carousel" data-slide-to="3"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    @foreach($list as $k=>$v)
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

                <a id="download" class="btn btn-danger btn-lg" href="#" target="_blank"><i class="fa fa-download" aria-hidden="true"></i> 立即下载</a>
            </div>
        </div>
    </div>
    <div class="container vedio">
        <div class="row">
            <div class="col-xs-12">
                <h1 class="text-center">一分钟快速入门，了解达购海淘</h1>
                <div class="text-center">
                    <embed src='http://player.youku.com/player.php/sid/XMjg0MDE4NDcxNg==/v.swf' allowFullScreen='true' quality='high' width='480' height='400' align='middle' allowScriptAccess='always' type='application/x-shockwave-flash'></embed>
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
</div>
<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdn.bootcss.com/vue/2.2.6/vue.js"></script>


<script>
    $(function () {
        $('.carousel').carousel()
    })
</script>

</body>
</html>
