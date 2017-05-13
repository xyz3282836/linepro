@extends('layouts.app')
@section('csslib')
    <link href="https://cdn.bootcss.com/bootstrap-datepicker/1.7.0-RC2/css/bootstrap-datepicker.min.css" rel="stylesheet">
@endsection

@section('jslib')
    <script src="https://cdn.bootcss.com/bootstrap-datepicker/1.7.0-RC2/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap-datepicker/1.7.0-RC2/locales/bootstrap-datepicker.zh-CN.min.js"></script>
@endsection
@section('css')
    <style type="text/css">

    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">{{$tname}}</div>
                    <div class="panel-body">
                        <form class="form-inline margin-bottom-30" action="{{url('viewclickfarm/'.$model->id)}}" method="post">
                            {{csrf_field()}}

                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="ASIN" name="asin" value="{{$asin}}">
                            </div>
                            <div class="form-group">
                                <div class="input-daterange input-group" id="datepicker">
                                    <input type="text" class="form-control" name="start" value="{{$start}}" />
                                    <span class="input-group-addon">to</span>
                                    <input type="text" class="form-control" name="end" value="{{$end}}" />
                                </div>
                            </div>
                            <div class="form-group">
                                <select class="form-control select-sm" name="status" required v-model="status">
                                    <option v-for="(v,k) in statusc" v-text="v" :value="k"></option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary ladda-button" data-style="contract">查询</button>
                        </form>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    {{--<th>商品图片</th>--}}
                                    {{--<th>商品title</th>--}}
                                    {{--<th>店铺id</th>--}}
                                    <th>账号邮箱</th>
                                    <th>亚马逊订单号</th>
                                    <th>物流</th>
                                    <th>物流单号</th>
                                    <th>更新时间</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($list as $v)
                                <tr>
                                    <td>{{$v->id}}</td>
                                    <td>{{$v->amazon_email}}</td>
                                    <td>{{$v->amazon_orderid}}</td>
                                    <td>{{$v->amazon_logistics_company}}</td>
                                    <td>{{$v->amazon_logistics_orderid}}</td>
                                    <td>{{$v->updated_at}}</td>
                                    <td>{{$v->status_text}}</td>
                                    <td>
                                        @if($v->status == 6)
                                            <button class="btn btn-success btn-sm ladda-button" data-style="contract" @click="evaluate({{$v->id}})">评价</button>
                                        @endif

                                    </td>
                                </tr>
                                @empty
                                 <tr>
                                     <td colspan="99">no data</td>
                                 </tr>
                                @endforelse
                            </tbody>
                        </table>
                        @if($list)
                            {!!  $list->appends(['asin'=>$asin,'start'=>$start,'end'=>$end,'status'=>$status])->links() !!}
                        @endif
                    </div>
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
        });
        new Vue({
            el: '#app',
            data:{
                statusc: JSON.parse('{!! json_encode(App\CfResult::OUT_TEXT) !!}'),
                status:'{{$status}}'
            },
            methods: {
                evaluate:function (id) {
                    axios.post("{{url('evaluate')}}",{id:id}).then(function (d) {
                        var data = d.data;
                        if(!data.code){
                            layer.msg(data.msg, {icon: 2});
                        }else{
                            layer.msg('操作成功', {icon: 1});
                            window.location.reload()
                        }
                    })
                },
            },
            mounted: function () {
                this.$nextTick(() => {
                })
            },
        });
    </script>
@endsection