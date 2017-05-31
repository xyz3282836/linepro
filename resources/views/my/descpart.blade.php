@extends('layouts.app')
@section('css')
    <style type="text/css">
        .col-md-6.control-label{
            text-align: left;
        }
    </style>
@endsection

@section('jslib')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">个人设置页面</div>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('upmy') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="col-md-4 control-label">昵称</label>
                                <label class="col-md-6 control-label">{{ $user->name }}</label>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Email</label>
                                <label class="col-md-6 control-label">{{ $user->email }}</label>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">手机</label>
                                <label class="col-md-6 control-label">{{ mask_number($user->mobile,5) }}</label>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">身份证号码</label>
                                <label class="col-md-6 control-label">{{ mask_number($user->idcardno,10) }}</label>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">身份证件图</label>
                                <label class="col-md-6 control-label">已上传</label>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">会员状态</label>
                                <label class="col-md-6 control-label">{{ $user->level_text }}</label>
                            </div>

                            <div class="form-group">
                                <label for="real_name" class="col-md-4 control-label">真实姓名</label>
                                <div class="col-md-6">
                                    <input id="real_name" type="text" class="form-control" name="real_name" value="{{ $user->real_name }}" minlength="2" maxlength="6" required>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>
                            <input type="hidden" name="idcardno" value="{{$user->idcardno}}">
                            <input type="hidden" name="idcardpic" value="{{$user->idcardpic}}">
                            <input type="hidden" name="mobile" value="{{$user->mobile}}">
                            <div class="form-group">
                                <label for="addr" class="col-md-4 control-label">联系地址</label>

                                <div class="col-md-6">
                                    <input id="addr" type="text" class="form-control" name="addr" value="{{ $user->addr }}" minlength="5" maxlength="50" required>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="shipping_addr" class="col-md-4 control-label">发货地址</label>

                                <div class="col-md-6">
                                    <input id="shipping_addr" type="text" class="form-control" name="shipping_addr" value="{{ $user->shipping_addr }}" minlength="5" maxlength="50" required>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary ladda-button" data-style="contract">
                                        提交
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
            methods: {
            },
            mounted: function () {
                this.$nextTick(()=>{
                })
            },
            data:{
            }
        });
        $(function () {

        })
    </script>
@endsection


