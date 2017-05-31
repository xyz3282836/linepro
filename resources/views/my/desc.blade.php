@extends('layouts.app')
@section('css')
    <style type="text/css">
        .col-md-6.control-label{
            text-align: left;
        }
    </style>
@endsection

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

                            <div class="form-group" v-for="(one,index) in picarr">
                                <label class="col-md-4 control-label" >身份证图片 <span v-text="index + 1"></span></label>
                                <div class="col-md-6">
                                    <img :src="one" alt="" width="200">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="real_name" class="col-md-4 control-label">真实姓名</label>
                                <div class="col-md-6">
                                    <input id="real_name" type="text" class="form-control" name="real_name" value="{{ Auth::user()->real_name }}" minlength="2" maxlength="6" required>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('idcardno') ? ' has-error' : '' }}">
                                <label for="idcardno" class="col-md-4 control-label">身份证号码</label>
                                <div class="col-md-6">
                                    <input id="idcardno"  type="text" class="form-control" pattern="[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)" name="idcardno" value="{{ Auth::user()->idcardno }}" required>
                                    <p class="help-block with-errors">{{ $errors->first('idcardno') }}</p>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('idcardpic') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">身份证图片(正反)</label>
                                <div class="col-md-6">
                                    <input id="mutipic" type="file" class="file-loading" accept="image/*" name="upimg" multiple>
                                    <p class="help-block with-errors">{{ $errors->first('idcardpic') }}</p>
                                </div>
                            </div>
                            <input type="hidden" name="idcardpic" id="mutipicval" value="{{Auth::user()->idcardpic}}">

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
                                <label for="shipping_addr" class="col-md-4 control-label">发货地址</label>

                                <div class="col-md-6">
                                    <input id="shipping_addr" type="text" class="form-control" name="shipping_addr" value="{{ Auth::user()->shipping_addr }}" minlength="5" maxlength="50" required>
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
                getpic:function(){
                    if(this.pic == ''){
                        return;
                    }
                    this.picarr =this.pic.split(',')
                },
            },
            mounted: function () {
                this.$nextTick(()=>{
                    this.getpic();
                })
            },
            data:{
                pic:"{{Auth::user()->idcardpic}}",
                picarr:[],
            }
        });
        var picarr = [];
        var picarrid = [];
        var picarrwith = [];
        $(function () {
            function chkimgs(img,id) {
                if(picarr.length>=2){
                    return false;
                }else{
                    picarrwith[id] = img;
                    picarr.push(img);
                    picarrid.push(id);
                    return true;
                }
            }
            function delimgs(id) {
                var index = picarrid.indexOf(id);
                if(index > -1){
                    var iindex = picarr.indexOf(picarrwith[id]);
                    if(iindex > -1){
                        picarr.splice(iindex,1);
                    }
                    picarrid.splice(index,1);
                }
            }
            $("#mutipic").fileinput({
                language: 'zh',
                allowedFileExtensions: ['jpeg', 'jpg', 'png', 'gif'],//接收的文件后缀
                uploadUrl: "{{url('upload?type=idcard')}}", //上传的地址
                maxFileCount: 2,
                maxFileSize: 2000,
                allowedFileTypes: ['image'],
                uploadExtraData: {
                    _token: "{{csrf_token()}}",
                },
//                elErrorContainer:false
            }).on("fileuploaded", function(event, data,previewId, index) {
                if(data.response.code){
                    if(!chkimgs(data.response.data,previewId)){
                        layer.msg('超过2张图片了', {icon: 2});
                    }
                }
                $('#mutipicval').val(picarr)
            }).on('fileclear', function(event) {
                picarr = [];
                picarrid = [];
                picarrwith = [];
                $('#mutipicval').val('')
            }).on('filesuccessremove', function(event, id) {
                delimgs(id)
                $('#mutipicval').val(picarr)
            });
        })
    </script>
@endsection


