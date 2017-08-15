<!DOCTYPE html>
<html lang="{{ gconfig('site.name') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ gconfig('site.name') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    {{--<link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">--}}
    <link href="https://cdn.bootcss.com/Ladda/1.0.0/ladda-themeless.min.css" rel="stylesheet">

    @yield('csslib')

    <style>
        .color-red{
            color:red;
        }
        .color-green{
            color:#2ab27b;
        }
        .ladda-button[data-style=contract] {
            width: auto;
        }
        .btn-sm.ladda-button[data-style=contract][data-loading] {
            width: 30px;
        }
        .ladda-button[data-style=contract][data-loading][type=submit] {
            width: 36px;
        }
        .margin-bottom-30{
            margin-bottom: 30px;
        }
        table td{
            max-width: 300px;
        }
        table th,table td{
            text-align: center;
            vertical-align:middle!important;
        }
        table .limit{
            max-width: 150px;
            text-align: left;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
    @yield('css')
    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
    <div id="app">
        @section('body')
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ gconfig('site.name') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    @if (!Auth::guest())
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="{{url('card')}}">购物车</a>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                订单管理 <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{url('orderlist')}}">我的订单</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    @endif

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">登入</a></li>
                            <li><a href="{{ route('register') }}">注册</a></li>
                        @else
                            <li><a href="{{ url('billlist') }}">账单</a></li>
                            <li class="dropdown">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    地址管理 <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ url('addr') }}">达购转运</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{Auth::user()->level_text}}
                                    金币:<span class="color-red">{{Auth::user()->golds}}G</span>
                                    <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ url('recharge') }}">充值金币</a></li>
                                    <li><a href="{{ url('rechargelist') }}">充值记录</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="{{ url('viplist') }}">会员有效期记录</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                    余额:<span class="color-red">{{Auth::user()->balance}}元</span>
                                    <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ url('my') }}">个人资料</a></li>
                                    <li><a href="{{ url('uppwd') }}">修改密码</a></li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            退出账号
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        <li><a href="{{ url('faqs') }}">帮助</a></li>
                        <li><a href="#">在线客服</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')

        @show
    </div>
    {{--<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>--}}
    {{--<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>--}}
    {{--<script src="https://cdn.bootcss.com/vue/2.2.6/vue.js"></script>--}}
    <script src="https://cdn.bootcss.com/axios/0.16.1/axios.min.js"></script>
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="https://cdn.bootcss.com/layer/3.0.1/layer.min.js"></script>
    <script src="https://cdn.bootcss.com/Ladda/1.0.0/spin.min.js"></script>
    <script src="https://cdn.bootcss.com/Ladda/1.0.0/ladda.min.js"></script>
    @yield('jslib')

    <script>
        $(function () {
            Ladda.bind( 'table .ladda-button', { timeout: 1500 } );
            Ladda.bind( 'form .btn.ladda-button[type=submit]', { timeout: 3000 } );
        })
    </script>
    @yield('js')
</body>
</html>
