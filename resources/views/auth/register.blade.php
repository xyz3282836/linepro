@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">注册</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">用户名</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                            <label for="mobile" class="col-md-4 control-label">手机号</label>
                            <div class="col-md-6">
                                <input id="mobile" pattern="1[345789][0-9]{9}" type="text" class="form-control" name="mobile" value="{{ old('mobile') }}" required>
                                @if ($errors->has('mobile'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mobile') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('addr') ? ' has-error' : '' }}">
                            <label for="addr" class="col-md-4 control-label">联系地址</label>

                            <div class="col-md-6">
                                <input id="addr" type="text" class="form-control" name="addr" value="{{ old('addr') }}" minlength="5" maxlength="50" required>

                                @if ($errors->has('addr'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('addr') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('management_type') ? ' has-error' : '' }}">
                            <label for="shop_id" class="col-md-4 control-label">经营类目</label>

                            <div class="col-md-6">

                                <select class="form-control" name="management_type" id="management_type" required>
                                    <option v-for="(v,k) in cs" v-text="v" :value="k"></option>
                                </select>

                                @if ($errors->has('management_type'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('management_type') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('shop_id') ? ' has-error' : '' }}">
                            <label for="shop_id" class="col-md-4 control-label">店铺ID</label>

                            <div class="col-md-6">
                                <input id="shop_id" type="text" class="form-control" name="shop_id" value="{{ old('shop_id') }}" required>

                                @if ($errors->has('shop_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('shop_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">密码</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">确认密码</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary ladda-button" data-style="contract">
                                    注册
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('js')
    <script>
        new Vue({
            el: '#app',
            methods: {},
            data:{
                cs:JSON.parse('{!! json_encode(config('linepro.mc')) !!}'),
            }
        })
    </script>
@endsection