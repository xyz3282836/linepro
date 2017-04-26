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
                                <div class="col-md-2"><p class="color-red">+ <span v-text="price_platform"></span> 元</p></div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 购买的ASIN</label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="" class="form-control" minlength="24" maxlength="24" name="asin" required>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 是否直评</label>
                                <div class="col-md-6">
                                    <label class="radio-inline">
                                        <input type="radio" value="1" name="is_direct" v-model="is_direct" required> 是
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" value="0" name="is_direct" v-model="is_direct" required> 否
                                    </label>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">关联刷单任务ID</label>
                                <div class="col-md-6">
                                    <input type="number" :disabled="is_direct == 1" placeholder="" min="1" class="form-control"
                                           name="cfid">
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
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 总价格</label>
                                <div class="col-md-6"><p class="color-red">共计 <span v-text="getprice"></span> 元</p></div>
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
                    this.price_platform = this.price.platform[this.platform_type];
                })
            },
            computed:{
                getprice:function () {
                    return this.price_platform;
                }
            },
            data: {
                platform_type:1,
                is_direct:1,
                price:JSON.parse('{!! json_encode(config('linepro.evaluate_price')) !!}'),
                price_platform:0,
            }
        });
        $(function () {
            $('#start_time').datetimepicker({
                format: 'yyyy-mm-dd hh:ii',
                language:'zh-CN',
                autoclose:true,
                todayHighlight: 1,
            });
        })
    </script>
@endsection