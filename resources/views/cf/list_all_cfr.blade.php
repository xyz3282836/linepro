@extends('layouts.app')
@section('csslib')
    <link href="https://cdn.bootcss.com/bootstrap-datepicker/1.7.0-RC2/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="{{url('flagicon/css/flag-icon.min.css')}}" rel="stylesheet">
@endsection

@section('jslib')
    <script src="https://cdn.bootcss.com/bootstrap-datepicker/1.7.0-RC2/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap-datepicker/1.7.0-RC2/locales/bootstrap-datepicker.zh-CN.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>
@endsection
@section('css')
    <style type="text/css">
        .breadcrumb{
            margin-bottom: 0;
        }
        table .limit{
            word-wrap: break-word;
            text-align: left;
            max-height: 80px;
            line-height: 20px;

            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    {{--<div class="panel-heading">--}}
                        {{----}}
                    {{--</div>--}}
                    <ol class="breadcrumb">
                        <li><a href="/">首页</a></li>
                        <li class="active">所有评价任务</li>
                    </ol>
                    <div class="panel-body">
                        <form class="form-inline margin-bottom-30" action="{{url('mycfrlist')}}" method="get">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="ASIN" name="asin" value="{{$asin}}">
                            </div>
                            <div class="form-group">
                                <select class="form-control select-sm" name="site" required v-model="site">
                                    <option v-for="(v,k) in sitec" v-text="v" :value="k"></option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control select-sm" name="type" required v-model="type">
                                    <option v-for="(v,k) in typec" v-text="v" :value="k"></option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary ladda-button" data-style="contract">查询</button>
                        </form>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>商品图片</th>
                                    <th>站点</th>
                                    {{--<th>店铺id</th>--}}
                                    <th>ASIN</th>
                                    <th>亚马逊订单号</th>
                                    {{--<th>物流</th>--}}
                                    <th>物流单号</th>
                                    <th>评价详情</th>
                                    <th>状态</th>
                                    <th>评价</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($list as $v)
                                <tr>
                                    <td>{{$v->id}}</td>
                                    <td><a href="{{$v->cf->amazon_pic}}"><img src="{{$v->cf->amazon_pic}}" width="100" alt=""></a></td>
                                    <td><span class="flag-icon flag-icon-{{$v->cf->flag}}"></span></td>
{{--                                    <td>{{$v->shop_id}}</td>--}}
                                    <td>{{$v->asin}}</td>
                                    <td>{{$v->amazon_orderid}}</td>
{{--                                    <td>{{$v->amazon_logistics_company}}</td>--}}
                                    <td>{{$v->amazon_logistics_orderid}}</td>
                                    <td width="300" style="text-align: left">
                                        <p>评价星级：@if($v->estatus > 1){{$v->star}} @endif</p>
                                        <p>评价标题：{{$v->title}}</p>
                                        <div class="limit">
                                            评价内容：{{$v->content}}
                                        </div>
                                    </td>
                                    <td>{{$v->status_text}}</td>
                                    <td data-estatus="{{$v->estatus}}" data-star="{{$v->star}}" data-title="{{$v->title}}" data-content="{{$v->content}}">
                                        @if(in_array($v->estatus,[1,2,3]))
                                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#evaluatecf" data-id="{{$v->id}}">{{$v->estatus_text}}</button>
                                        @elseif($v->estatus == 7)
                                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#evaluatecf" data-id="{{$v->id}}">{{$v->estatus_text}}</button>
                                        @elseif($v->estatus == 5)
                                            {{$v->estatus_text}} <a href="{{$v->amazon_review_id}}" target="_blank">查看</a>
                                        @else
                                            {{$v->estatus_text}}
                                        @endif
                                            @if($v->estatus != 5)
                                        <br>
                                        预计{{$v->etime}}后留评
                                            @endif
                                        @if($v->estatus == 7)
                                            <br>
                                            <span class="color-red">评价文字重复</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                 <tr>
                                     <td colspan="99">暂无数据</td>
                                 </tr>
                                @endforelse
                            </tbody>
                        </table>
                        @if($list)
                            {!!  $list->appends(['type'=>$type,'asin'=>$asin,'site'=>$site])->links() !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="evaluatecf" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">评价</h4>
                </div>
                <div class="modal-body">
                    <form id="eform">
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">星级：</label>
                            <label class="radio-inline">
                                <input type="radio" name="star" value="1" v-model="star" required>一星
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="star" value="2" v-model="star" required>二星
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="star" value="3" v-model="star" required>三星
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="star" value="4" v-model="star" required>四星
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="star" value="5" v-model="star" required>五星
                            </label>
                            <p class="help-block with-errors"></p>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">标题：</label>
                            <input type="text" class="form-control" name="title" id="title" v-model="title" required>
                            <p class="help-block with-errors"></p>
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="control-label">正文：</label>
                            <textarea class="form-control" name="content" id="content" v-model="content" required></textarea>
                            <p class="help-block with-errors"></p>
                        </div>
                        <input type="hidden" name="id" id="eid">
                        <button type="submit" class="btn btn-primary ladda-button" data-style="contract">提交评价</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(function(){
            $('.input-daterange').datepicker({
                format: 'yyyy-mm-dd',
                language:'zh-CN',
                autoclose:true,
                todayHighlight: true,
            });
            $('#evaluatecf').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var modal = $(this);
                modal.find('#eid').val(id);
                var td = button.closest('td');
                var estatus = Number(td.data('estatus'));
                var star = td.data('star');
                var title = td.data('title');
                var content = td.data('content');
                app.star = estatus > 1?star:0;
                app.title = title;
                app.content = content;
            });

            $('#eform').validator().on('submit', function (e) {
                if(!e.isDefaultPrevented())  {
                    e.preventDefault();
                    axios.post("{{url('cf/evaluate')}}",$(this).serialize()).then(function (d) {
                        var data = d.data;
                        if(!data.code){
                            layer.msg(data.msg, {icon: 2});
                        }else{
                            layer.msg('操作成功', {icon: 1});
                            window.location.reload()
                        }
                    })
                }
            });
        });

        var app = new Vue({
            el: '#app',
            data:{
                type: "{{$type}}",
                typec: {!! json_encode(config('linepro.cfr_typec')) !!},
                site:"{{$site}}",
                sitec: {!! json_encode(config('linepro.cfr_sitec')) !!},
                star:0,
                title:'',
                content:''
            },
            methods: {
            },
            mounted: function () {
                this.$nextTick(() => {
                })
            },
        });
    </script>
@endsection