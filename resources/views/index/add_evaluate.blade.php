@extends('layouts.app')

@section('csslib')
    <link href="{{URL::asset('bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
@endsection

@section('css')
    <style>
        .color-red{
            color:red;
        }
    </style>
@endsection

@section('jslib')
    <script src="{{URL::asset('bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{URL::asset('bootstrap-datetimepicker/js/bootstrap-datetimepicker.zh-CN.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">添加刷单任务</div>
                    <div class="panel-body">
                        <form class="form-horizontal" data-toggle="validator" role="form" method="POST" action="{{ url('addevaluate') }}">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 平台</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="platform_type" required>
                                        <option value="1">amazon.com</option>
                                    </select>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 购买的ASIN</label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="" class="form-control" minlength="24" maxlength="24" name="asin" required>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 关联刷单任务ID</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="cfid" required>
                                        @foreach($list as $v)
                                            <option value="{{$v['id']}}">{{$v['orderid']}}</option>
                                        @endforeach
                                    </select>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 星级</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="star" required>
                                        <option value="1">一星</option>
                                        <option value="2">二星</option>
                                        <option value="3">三星</option>
                                        <option value="4">四星</option>
                                        <option value="5">五星</option>
                                    </select>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 标题</label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="" min="1" class="form-control"
                                           name="title" minlength="3" maxlength="64" required>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 正文</label>
                                <div class="col-md-6">
                                    <div class="textarea">
                                        <textarea rows="3" class="form-control" name="content" maxlength="1000" required></textarea>
                                    </div>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">图片1</label>
                                <div class="col-md-6">
                                    <input type="URL" class="form-control" name="pic[]"
                                           placeholder="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">图片2</label>
                                <div class="col-md-6">
                                    <input type="URL" class="form-control" name="pic[]"
                                           placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">图片3</label>
                                <div class="col-md-6">
                                    <input type="URL" class="form-control" name="pic[]"
                                           placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">图片4</label>
                                <div class="col-md-6">
                                    <input type="URL" class="form-control" name="pic[]"
                                           placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">图片5</label>
                                <div class="col-md-6">
                                    <input type="URL" class="form-control" name="pic[]"
                                           placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">图片6</label>
                                <div class="col-md-6">
                                    <input type="URL" class="form-control" name="pic[]"
                                           placeholder="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">视频</label>
                                <div class="col-md-6">
                                    <input type="URL" class="form-control" name="video"
                                           placeholder="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 刷单开始时间</label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="" class="form-control" name="start_time" id="start_time" required>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
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
            methods:{

            },
            mounted: function () {
                this.$nextTick(()=>{

                })
            },
            computed:{
            },
            data: {
            }
        });
        $(function () {
            $('#start_time').datetimepicker({
                format: 'yyyy-mm-dd hh:ii',
                language:'zh-CN',
                autoclose:true,
                todayHighlight: 1,
                startDate: new Date()
            });
        })
    </script>
@endsection