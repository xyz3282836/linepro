@extends('layouts.app')

@section('csslib')
    <link href="{{URL::asset('bootstrap-fileinput/css/fileinput.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
@endsection

@section('jslib')
    <script src="{{URL::asset('bootstrap-fileinput/js/fileinput.js')}}"></script>
    <script src="{{URL::asset('bootstrap-fileinput/js/locales/zh.js')}}"></script>
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
                                        <option v-for="(v,k) in platformc" v-text="v" :value="k"></option>
                                    </select>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 购买的ASIN</label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="" class="form-control" minlength="1" maxlength="24" name="asin" required>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 关联刷单任务ID</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="cfid" required>
                                        <option value="0">不关联</option>
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
                                <label class="col-md-4 control-label">图片</label>
                                <div class="col-md-6">
                                    <input id="picarr" type="file" class="file-loading" accept="image/*" name="upimg" multiple>
                                </div>
                            </div>
                            <input type="hidden" name="pic" id="pic">

                            <div class="form-group">
                                <label class="col-md-4 control-label">视频</label>
                                <div class="col-md-6">
                                    <input id="videoarr" type="file" class="file-loading" accept="video/*" name="upvideo">
                                </div>
                            </div>
                            <input type="hidden" name="video" id="video">

                            <div class="form-group">
                                <label class="col-md-4 control-label"><span class="color-red">*</span> 刷单开始时间</label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="" class="form-control" name="start_time" id="start_time" required>
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
            methods:{

            },
            mounted: function () {
                this.$nextTick(()=>{

                })
            },
            computed:{
            },
            data: {
                platformc:JSON.parse('{!! json_encode(config('linepro.platformc')) !!}'),
            }
        });
        var picarr = [];
        var picarrid = [];
        var picarrwith = [];
        $(function () {
            $('#start_time').datetimepicker({
                format: 'yyyy-mm-dd hh:ii',
                language: 'zh-CN',
                autoclose: true,
                todayHighlight: 1,
                startDate: new Date()
            });

            function chkimgs(img,id) {
                if(picarr.length>=6){
                    return false;
                }else{
                    picarrwith[id] = img;
                    picarr.push(img);
                    picarrid.push(id);
                    getc();
                    return true;
                }

            }
            function delimgs(id) {
                console.log(id);
                var index = picarrid.indexOf(id);
                console.log('id');
                console.log(index);
                if(index > -1){
                    var iindex = picarr.indexOf(picarrwith[id]);
                    console.log('img')
                    console.log(iindex)
                    if(iindex > -1){
                        picarr.splice(iindex,1);
                    }
                    picarrid.splice(index,1);
                }

                getc()
            }
            function getc() {
                console.log(picarr)
                console.log(picarrid)
                console.log(picarrwith)
            }
            $("#picarr").fileinput({
                language: 'zh',
                allowedFileExtensions: ['jpeg', 'jpg', 'png', 'gif'],//接收的文件后缀
                uploadUrl: "{{url('upload?type=img')}}", //上传的地址
                maxFileCount: 6,
                maxFileSize: 2000,
                allowedFileTypes: ['image'],
                uploadExtraData: {
                    _token: "{{csrf_token()}}",
                },
                elErrorContainer:false
            }).on("fileuploaded", function(event, data,previewId, index) {
                if(data.response.code){
                    if(!chkimgs(data.response.data,previewId)){
                        layer.msg('超过6张图片了', {icon: 2});
                    }
                }
                $('#pic').val(picarr)
            }).on('fileclear', function(event) {
                picarr = [];
                picarrid = [];
                picarrwith = [];
                $('#pic').val('')
            }).on('filesuccessremove', function(event, id) {
                delimgs(id)
                $('#pic').val(picarr)
            });

            $("#videoarr").fileinput({
                language: 'zh',
                allowedFileExtensions: ['mp4'],//接收的文件后缀
                uploadUrl: "{{url('upload?type=video')}}", //上传的地址
                maxFileCount: 1,
                maxFileSize: 20000,
                allowedFileTypes: ['video'],
                uploadExtraData: {
                    _token: "{{csrf_token()}}"
                },
                elErrorContainer:false
            }).on("fileuploaded", function(event, data,previewId, index) {
                if(data.response.code){
                    $('#video').val(data.response.data)
                }
            }).on('fileclear', function(event) {
                $('#video').val('')
            }).on('filesuccessremove', function(event, id) {
                $('#video').val('')
            });

        });
    </script>
@endsection