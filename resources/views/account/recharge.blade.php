@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">充值页面</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('recharge') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">Mobile</label>

                                <div class="col-md-6">
                                    <input id="mobile" type="number" class="form-control" name="mobile" required value="{{ old('mobile') }}" required autofocus>
                                    <p class="help-block with-errors">
                                        @if ($errors->has('mobile'))
                                            {{ $errors->first('mobile') }}
                                        @endif
                                    </p>

                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('account') ? ' has-error' : '' }}">
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
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> 记住我
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        登入
                                    </button>

                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        忘记密码?
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



