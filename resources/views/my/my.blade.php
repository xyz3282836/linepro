@extends('layouts.app')
@section('css')
    <style type="text/css">
        .col-md-6.control-label{
            text-align: left;
        }
    </style>
@endsection


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">个人资料</div>

                    <div class="panel-body">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label class="col-md-4 control-label">昵称</label>
                                <label class="col-md-6 control-label">{{ $user->name }}</label>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Email</label>
                                <label class="col-md-6 control-label">{{ mask_email($user->email) }}</label>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">会员状态</label>
                                <label class="col-md-6 control-label">{{ $user->level_text }}</label>
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


