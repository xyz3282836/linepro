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
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label class="col-md-4 control-label">商铺ID</label>
                                <label class="col-md-6 control-label">{{$el->shop_id}}</label>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">平台</label>
                                <label class="col-md-6 control-label" v-text="c1[platform_type]"></label>
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
                                <label class="col-md-6 control-label" v-text="one"></label>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">视频</label>
                                <label class="col-md-6 control-label">{{$el->video}}</label>
                            </div>

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
                }
            },
            mounted: function () {
                this.$nextTick(()=>{
                    this.getpic();
                })
            },
            data: {
                c1:{
                    1:'amazon.com'
                },
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