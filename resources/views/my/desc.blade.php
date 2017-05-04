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
            <div class="col-md-8 col-md-offset-2">
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
                                <label for="mobile" class="col-md-4 control-label">昵称</label>
                                <label for="mobile" class="col-md-6 control-label">{{ Auth::user()->name }}</label>
                            </div>
                            <div class="form-group">
                                <label for="mobile" class="col-md-4 control-label">Email</label>
                                <label for="mobile" class="col-md-6 control-label">{{ Auth::user()->email }}</label>
                            </div>
                            <div class="form-group">
                                <label for="mobile" class="col-md-4 control-label">会员状态</label>
                                <label for="mobile" class="col-md-6 control-label">{{ Auth::user()->level_text }}</label>
                            </div>
                            <div class="form-group">
                                <label for="mobile" class="col-md-4 control-label">手机号</label>
                                <div class="col-md-6">
                                    <input id="mobile" pattern="1[345789][0-9]{9}" type="text" class="form-control" name="mobile" value="{{ Auth::user()->mobile }}" required>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="addr" class="col-md-4 control-label">联系地址</label>

                                <div class="col-md-6">
                                    <input id="addr" type="text" class="form-control" name="addr" value="{{ Auth::user()->addr }}" minlength="5" maxlength="50" required>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="shop_id" class="col-md-4 control-label">经营类目</label>

                                <div class="col-md-6">
                                    <select class="form-control" name="management_type" id="management_type" v-model="management_type" required>
                                        <option v-for="(v,k) in cs" v-text="v" :value="k"></option>
                                    </select>
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
            methods: {},
            data:{
                cs:JSON.parse('{!! json_encode(config('linepro.mc')) !!}'),
                management_type:'{{Auth::user()->management_type}}'
            }
        })
    </script>
@endsection


