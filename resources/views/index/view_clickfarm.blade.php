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
                    <div class="panel-heading">未完成刷单任务详细信息</div>
                    <div class="panel-body">
                        <form class="form-horizontal">

                            <div class="form-group">
                                <label class="col-md-4 control-label">平台</label>
                                <label class="col-md-6 control-label" v-text="c1[platform_type]"></label>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">购买的ASIN</label>
                                <label class="col-md-6 control-label">{{$cf->asin}}</label>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">是否FBA发货</label>
                                <label class="col-md-6 control-label" v-text="c2[is_fba]"></label>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">优惠码</label>
                                <label class="col-md-6 control-label">{{$cf->discount_code}}</label>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">最终价格(包含运费)</label>
                                <label class="col-md-6 control-label">{{$cf->final_price}}</label>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">是否需要Reviews</label>
                                <label class="col-md-6 control-label" v-text="c2[is_reviews]"></label>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">指定ASIN购买</label>
                                <label class="col-md-6 control-label">{{$cf->specified_asin}}</label>
                            </div>

                            <div class="form-group" v-for="(ca,index) in contrast_asin">
                                <label class="col-md-4 control-label" >ASIN <span v-text="index + 1"></span></label>
                                <label class="col-md-6 control-label" v-text="ca"></label>
                            </div>


                            <div class="form-group">
                                <label class="col-md-4 control-label">浏览深度</label>
                                <label class="col-md-6 control-label" v-text="c3[brower]"></label>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">优先选择</label>
                                <label class="col-md-6 control-label" v-text="c4[priority]"></label>
                            </div>


                            <div class="form-group">
                                <label class="col-md-4 control-label">流量端口</label>
                                <label class="col-md-6 control-label" v-text="c5[flow_port]"></label>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">流量来源</label>
                                <label class="col-md-6 control-label" v-text="c6[source]"></label>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">浏览步骤</label>
                                <label class="col-md-6 control-label" v-text="c7[step]"></label>
                            </div>

                            {{--key--}}
                            <div class="form-group" v-if="keyw.source.indexOf(parseInt(source))>-1 && keyw.step.indexOf(parseInt(step))>-1">
                                <label class="col-md-4 control-label">关键词</label>
                                <label class="col-md-6 control-label">{{$mix['key_word']}}</label>
                            </div>

                            {{--low--}}
                            <div class="form-group" v-if="low.source.indexOf(parseInt(source))>-1 && low.step.indexOf(parseInt(step))>-1">
                                <label class="col-md-4 control-label">下级分类1</label>
                                <label class="col-md-6 control-label">{{$mix['lower_classification1']}}</label>
                            </div>
                            <div class="form-group" v-if="low.source.indexOf(parseInt(source))>-1 && low.step.indexOf(parseInt(step))>-1">
                                <label class="col-md-4 control-label">下级分类2</label>
                                <label class="col-md-6 control-label">{{$mix['lower_classification2']}}</label>
                            </div>
                            <div class="form-group" v-if="low.source.indexOf(parseInt(source))>-1 && low.step.indexOf(parseInt(step))>-1">
                                <label class="col-md-4 control-label">下级分类3</label>
                                <label class="col-md-6 control-label">{{$mix['lower_classification3']}}</label>
                            </div>
                            <div class="form-group" v-if="low.source.indexOf(parseInt(source))>-1 && low.step.indexOf(parseInt(step))>-1">
                                <label class="col-md-4 control-label">下级分类4</label>
                                <label class="col-md-6 control-label">{{$mix['lower_classification4']}}</label>
                            </div>

                            {{--wp--}}
                            <div class="form-group" v-if="wp.source.indexOf(parseInt(source))>-1 && wp.step.indexOf(parseInt(step))>-1">
                                <label class="col-md-4 control-label">外部网站</label>
                                <label class="col-md-6 control-label">{{$mix['outside_website']}}</label>
                            </div>
                            <div class="form-group" v-if="wp.source.indexOf(parseInt(source))>-1 && wp.step.indexOf(parseInt(step))>-1">
                                <label class="col-md-4 control-label">位置</label>
                                <label class="col-md-6 control-label">{{$mix['place']}}</label>
                            </div>

                            {{--crrsp--}}
                            {{--catg--}}
                            <div class="form-group" v-if="crrsp.source.indexOf(parseInt(source))>-1 && crrsp.step.indexOf(parseInt(step))>-1">
                                <label class="col-md-4 control-label">大分类</label>
                                <label class="col-md-6 control-label" v-text="cs[category]"></label>
                            </div>
                            {{--results--}}
                            <div class="form-group" v-if="crrsp.source.indexOf(parseInt(source))>-1 && crrsp.step.indexOf(parseInt(step))>-1 && results!=''">
                                <label class="col-md-4 control-label">Show results for(一级属性)</label>
                                <label class="col-md-6 control-label">{{$mix['first_attribute']}}</label>
                            </div>
                            <div class="form-group" v-if="crrsp.source.indexOf(parseInt(source))>-1 && crrsp.step.indexOf(parseInt(step))>-1 && results!=''">
                                <label class="col-md-4 control-label">Show results for(二级属性)</label>
                                <label class="col-md-6 control-label">{{$mix['second_attribute']}}</label>
                            </div>
                            {{--refine--}}
                            <div class="form-group" v-if="crrsp.source.indexOf(parseInt(source))>-1 && crrsp.step.indexOf(parseInt(step))>-1 && refine!=''">
                                <label class="col-md-4 control-label">Refine by(属性类别1组)</label>
                                <label class="col-md-6 control-label">{{$mix['attribute_group1']}}</label>
                            </div>
                            <div class="form-group" v-if="crrsp.source.indexOf(parseInt(source))>-1 && crrsp.step.indexOf(parseInt(step))>-1 && refine!=''">
                                <label class="col-md-4 control-label">Refine by(属性1组)</label>
                                <label class="col-md-6 control-label">{{$mix['attribute1']}}</label>
                            </div>
                            <div class="form-group" v-if="crrsp.source.indexOf(parseInt(source))>-1 && crrsp.step.indexOf(parseInt(step))>-1 && refine!=''">
                                <label class="col-md-4 control-label">Refine by(属性类别2组)</label>
                                <label class="col-md-6 control-label">{{$mix['attribute_group2']}}</label>
                            </div>
                            <div class="form-group" v-if="crrsp.source.indexOf(parseInt(source))>-1 && crrsp.step.indexOf(parseInt(step))>-1 && refine!=''">
                                <label class="col-md-4 control-label">Refine by(属性2组)</label>
                                <label class="col-md-6 control-label">{{$mix['attribute2']}}</label>
                            </div>
                            <div class="form-group" v-if="crrsp.source.indexOf(parseInt(source))>-1 && crrsp.step.indexOf(parseInt(step))>-1 && refine!=''">
                                <label class="col-md-4 control-label">Refine by(属性类别3组)</label>
                                <label class="col-md-6 control-label">{{$mix['attribute_group3']}}</label>
                            </div>
                            <div class="form-group" v-if="crrsp.source.indexOf(parseInt(source))>-1 && crrsp.step.indexOf(parseInt(step))>-1 && refine!=''">
                                <label class="col-md-4 control-label">Refine by(属性3组)</label>
                                <label class="col-md-6 control-label">{{$mix['attribute3']}}</label>
                            </div>
                            {{--sort--}}
                            <div class="form-group" v-if="crrsp.source.indexOf(parseInt(source))>-1 && crrsp.step.indexOf(parseInt(step))>-1">
                                <label class="col-md-4 control-label">sort by</label>
                                <label class="col-md-6 control-label" v-text="c8[sort_by]"></label>
                            </div>
                            {{--page--}}
                            <div class="form-group" v-if="crrsp.source.indexOf(parseInt(source))>-1 && crrsp.step.indexOf(parseInt(step))>-1">
                                <label class="col-md-4 control-label">page</label>
                                <label class="col-md-6 control-label" v-text="c9[page]"></label>
                            </div>

                            {{--ba--}}
                            <div class="form-group" v-if="ba.source.indexOf(parseInt(source))>-1 && ba.step.indexOf(parseInt(step))>-1">
                                <label class="col-md-4 control-label">B在A中的位置</label>
                                <label class="col-md-6 control-label" v-text="c10[ba_place]"></label>
                            </div>
                            <div class="form-group" v-if="ba.source.indexOf(parseInt(source))>-1 && ba.step.indexOf(parseInt(step))>-1">
                                <label class="col-md-4 control-label">A产品的ASIN</label>
                                <label class="col-md-6 control-label">{{$mix['ba_asin']}}</label>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">刷单件数</label>
                                <label class="col-md-6 control-label">{{$cf->task_num}}</label>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">刷单开始时间</label>
                                <label class="col-md-6 control-label">{{$cf->start_time}}</label>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">刷单间隔</label>
                                <label class="col-md-6 control-label">{{$cf->interval_time}} 分钟</label>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">客户留言</label>
                                <label class="col-md-6 control-label">{{$cf->customer_message}}</label>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">任务订单</label>
                                <label class="col-md-6 control-label">{{$cf->orderid}}</label>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">消费金额</label>
                                <label class="col-md-6 control-label">{{$cf->amount}}</label>
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
                getca:function(){
                    this.contrast_asin =this.cas.split(',')
                }
            },
            mounted: function () {
                this.$nextTick(()=>{
                    this.getca();
                })
            },
            data: {
                c1:{
                    1:'amazon.com'
                },
                c2:{
                    0:'否',
                    1:'是',
                    2:'不确定',
                },
                c3:{
                    1:'适度浏览',
                    2:'深度浏览',
                },
                c4:{
                    1:'正常随机',
                    2:'不刷广告',
                    3:'只刷广告',
                },
                c5:{
                    1:'PC端',
                    2:'移动端',
                },
                c6:{
                    1:'正常浏览',
                    2:'进A买B',
                },
                c7:{
                    1:'关键词搜索',
                    2:'分类挑选',
                    3:'其他网站跳转',
                },
                c8:{
                    1:'Price: Low to High',
                    2:'Price: High to Low',
                    3:'Avg. Customer Review',
                    4:'Newest Arrivals',
                },
                c9:{
                    1:'1-3',
                    2:'4-9',
                    3:'10-20',
                },
                c10:{
                    1:'Frequently Bought Together',
                    2:'Sponsored Products Related To This Item',
                    3:'Customers Who Bought This Item Also Bought',
                    4:'Customers Also Shopped For',
                    5:'What Other Items Do Customers Buy After Viewing This Item?',
                    6:'Compare to Similar Items',
                    7:'customers who viewd this item also viewd',
                },
                platform_type:{{ $cf->platform_type }},
                is_fba:{{$cf->is_fba}},
                is_reviews:{{$cf->is_reviews}},
                contrast_asin:[],
                cas:"{{$cf->contrast_asin}}",
                brower:{{$cf->brower}},
                priority:{{$cf->priority}},
                flow_port:{{$cf->flow_port}},
                source:{{$cf->flow_source}},
                step:{{$cf->browse_step}},
                cs: {
                    0:'不选类别直接搜索',
                    1:'Alexa Skills',
                    2:'Amazon Video',
                    3:'Amazon Warehouse Deals',
                    4:'Appliances',
                    5:'Apps & Games',
                    6:'Arts, Crafts & Sewing',
                    7:'Automotive Parts & Accessories',
                    8:'Baby',
                    9:'Beauty & Personal Care',
                    10:'Books',
                    11:'CDs & Vinyl',
                    12:'Cell Phones & Accessories',
                    13:'Clothing, Shoes & Jewelry',
                    14:'Women',
                    15:'Men',
                    16:'Girls',
                    17:'Boys',
                    18:'Baby',
                    19:'Collectibles & Fine Art',
                    20:'Computers',
                    21:'Courses',
                    22:'Credit and Payment Cards',
                    23:'Digital Music',
                    24:'Electronics',
                    25:'Gift Cards',
                    26:'Grocery & Gourmet Food',
                    27:'Handmade',
                    28:'Health, Household & Baby Care',
                    29:'Home & Business Services',
                    30:'Home & Kitchen',
                    31:'Industrial & Scientific',
                    32:'Kindle Store',
                    33:'Luggage & Travel Gear',
                    34:'Luxury Beauty',
                    35:'Magazine Subscriptions',
                    36:'Movies & TV',
                    37:'Musical Instruments',
                    38:'Office Products',
                    39:'Patio, Lawn & Garden',
                    40:'Pet Supplies',
                    41:'Prime Pantry',
                    42:'Software',
                    43:'Sports & Outdoors',
                    44:'Tools & Home Improvement',
                    45:'Toys & Games',
                    46:'Vehicles',
                    47:'Video Games',
                    48:'Wine',
                },
                results:"{{$mix['results']}}",
                refine:"{{$mix['refine']}}",
                category:"{{$mix['category']}}",//cs
                page:"{{$mix['page']}}",//c9
                sort_by:"{{$mix['sort_by']}}",//c8
                ba_place:"{{$mix['ba_place']}}",//c10
                crrsp:{
                    source:[1,2],
                    step:[1,2]
                },
                ba:{
                    source:[2],
                    step:[1,2,3]
                },
                keyw:{
                    source:[1,2],
                    step:[1]
                },
                low:{
                    source:[1,2],
                    step:[2]
                },
                wp:{
                    source:[1,2],
                    step:[3]
                }
            }
        })
    </script>
@endsection