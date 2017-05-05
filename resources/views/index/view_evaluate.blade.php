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
                    <div class="panel-heading">评价任务详细信息</div>
                    <div class="panel-body">

                        @if($el->status == 1)
                            <div class="text-center">
                                <button class="btn btn-danger btn-sm ladda-button" data-style="contract" @click="cancle({{$el->id}})">取消订单</button>
                                <button class="btn btn-success btn-sm ladda-button" data-style="contract" @click="pay({{$el->id}})">支付</button>
                            </div>
                        @endif

                        <form class="form-horizontal">
                            <div class="form-group">
                                <label class="col-md-4 control-label">订单状态</label>
                                <label class="col-md-6 control-label">{{$el->status_text}}</label>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">商铺ID</label>
                                <label class="col-md-6 control-label">{{$el->shop_id}}</label>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">平台</label>
                                <label class="col-md-6 control-label" v-text="platformc[platform_type]"></label>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">购买的ASIN</label>
                                <label class="col-md-6 control-label">{{$el->asin}}</label>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">关联刷单任务ID</label>
                                <label class="col-md-6 control-label">{{$el->cfid}}</label>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">星级</label>
                                <label class="col-md-6 control-label" v-text="c3[star]"></label>
                            </div>


                            <div class="form-group">
                                <label class="col-md-4 control-label">标题</label>
                                <label class="col-md-6 control-label">{{$el->title}}</label>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">正文</label>
                                <label class="col-md-6 control-label">{{$el->content}}</label>
                            </div>

                            <div class="form-group" v-for="(one,index) in picarr">
                                <label class="col-md-4 control-label" >图片 <span v-text="index + 1"></span></label>
                                <div class="col-md-6">
                                    <img :src="one" alt="" width="200">
                                </div>
                            </div>

                            @if($el->video != null)
                            <div class="form-group">
                                <label class="col-md-4 control-label">视频</label>
                                <div class="col-md-6">
                                    <video src="{{$el->video}}" controls="controls" width="500"></video>
                                </div>
                            </div>
                            @endif
                            <div class="form-group">
                                <label class="col-md-4 control-label">刷单开始时间</label>
                                <label class="col-md-6 control-label">{{$el->start_time}}</label>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">任务订单</label>
                                <label class="col-md-6 control-label">{{$el->orderid}}</label>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">消费金额</label>
                                <label class="col-md-6 control-label">{{$el->amount}}</label>
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
                getpic:function(){
                    if(this.pic == ''){
                        return;
                    }
                    this.picarr =this.pic.split(',')
                },
                pay:function (id) {
                    axios.post("{{url('pay')}}",{type:'evaluates',id:id}).then(function (d) {
                        var data = d.data;
                        if(!data.code){
                            layer.msg(data.msg, {icon: 2});
                        }else{
                            layer.msg('操作成功', {icon: 1});
                            window.location.reload()
                        }
                    })

                },
                cancle:function (id) {
                    axios.post("{{url('cancle')}}",{type:'evaluates',id:id}).then(function (d) {
                        var data = d.data;
                        if(!data.code){
                            layer.msg(data.msg, {icon: 2});
                        }else{
                            layer.msg('操作成功', {icon: 1});
                            window.location.reload()
                        }
                    })
                }
            },
            mounted: function () {
                this.$nextTick(()=>{
                    this.getpic();
                    Ladda.bind( '.btn', { timeout: 1500 } );
                })
            },
            data: {
                platformc:JSON.parse('{!! json_encode(config('linepro.platformc')) !!}'),
                star:{{$el->star}},
                platform_type:{{ $el->platform_type }},
                pic:"{{$el->pic}}",
                picarr:[],
                c2:{
                    0:'否',
                    1:'是',
                    2:'不确定',
                },
                c3:{
                    1:'一星',
                    2:'二星',
                    3:'三星',
                    4:'四星',
                    5:'五星',
                },
            }
        })
    </script>
@endsection