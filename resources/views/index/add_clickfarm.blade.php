@extends('layouts.app')

@section('csslib')
<link href="{{URL::asset('bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
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
                        <form class="form-horizontal" data-toggle="validator" role="form" method="POST" action="{{ url('addclickfarm') }}">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label class="col-md-4 control-label">平台</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="platform_type" required>
                                        <option value="1" selected>amazon.com</option>
                                    </select>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">购买的ASIN</label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="" class="form-control" minlength="24" maxlength="24" name="asin" required>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">是否FBA发货</label>
                                <div class="col-md-6">
                                    <label class="radio-inline">
                                        <input type="radio" value="0" name="is_fba" checked required> 否
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" value="1" name="is_fba" required> 是
                                    </label>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="优惠码" maxlength="24" class="form-control" name="discount_code">
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">最终价格(包含运费)</label>
                                <div class="col-md-6">
                                    <input type="number" placeholder="" required class="form-control" name="final_price">
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">是否需要Reviews</label>
                                <div class="col-md-6">
                                    <label class="radio-inline">
                                        <input type="radio" value="2" name="is_reviews" checked required> 不确定
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" value="1" name="is_reviews" required> 是
                                    </label>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">指定ASIN购买</label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="指定曾经购买过的ASIN" minlength="24" maxlength="24" class="form-control"
                                           name="specified_asin">
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">对比asin</label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="ASIN1" class="form-control" name="contrast_asin[]" minlength="24" maxlength="24">
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">对比asin</label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="ASIN1" class="form-control" name="contrast_asin[]" minlength="24" maxlength="24">
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">对比asin</label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="ASIN1" class="form-control" name="contrast_asin[]" minlength="24" maxlength="24">
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">浏览深度</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="brower" required>
                                        <option value="1" selected>适度浏览</option>
                                        <option value="2">深度浏览</option>
                                    </select>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">优先选择</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="priority" required>
                                        <option value="1" selected>正常随机</option>
                                        <option value="2">不刷广告</option>
                                        <option value="3">只刷广告</option>
                                    </select>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">流量端口</label>
                                <div class="col-md-6">
                                    <label class="radio-inline">
                                        <input type="radio" value="1" name="flow_port" checked required> PC端
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" value="2" name="flow_port" required> 移动端
                                    </label>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">流量来源</label>
                                <div class="col-md-6">
                                    <label class="radio-inline">
                                        <input type="radio" value="1" v-model="source" name="flow_source" checked required> 正常浏览
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" value="2" v-model="source" name="flow_source" required> 进A买B
                                    </label>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">浏览步骤</label>
                                <div class="col-md-6">
                                    <label class="radio-inline">
                                        <input type="radio" value="1" v-model="step" name="browse_step" checked required> 关键词搜索
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" value="2" v-model="step" name="browse_step" required> 分类挑选
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" value="3" v-model="step" name="browse_step" required> 其他网站跳转
                                    </label>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            {{--key--}}
                            <div class="form-group" v-show="keyw.source.indexOf(parseInt(source))>-1 && keyw.step.indexOf(parseInt(step))>-1">
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="关键词" class="form-control" name="key_word" maxlength="20">
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            {{--low--}}
                            <div class="form-group" v-show="low.source.indexOf(parseInt(source))>-1 && low.step.indexOf(parseInt(step))>-1">
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="下级分类1" class="form-control" name="lower_classification1" maxlength="20">
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>
                            <div class="form-group" v-show="low.source.indexOf(parseInt(source))>-1 && low.step.indexOf(parseInt(step))>-1">
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="下级分类2" class="form-control" name="lower_classification2" maxlength="20">
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>
                            <div class="form-group" v-show="low.source.indexOf(parseInt(source))>-1 && low.step.indexOf(parseInt(step))>-1">
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="下级分类3" class="form-control" name="lower_classification3" maxlength="20">
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>
                            <div class="form-group" v-show="low.source.indexOf(parseInt(source))>-1 && low.step.indexOf(parseInt(step))>-1">
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="下级分类4" class="form-control" name="lower_classification4" maxlength="20">
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            {{--wp--}}
                            <div class="form-group" v-show="wp.source.indexOf(parseInt(source))>-1 && wp.step.indexOf(parseInt(step))>-1">
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-6">
                                    <input type="URL" placeholder="外部网站" class="form-control" name="outside_website">
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>
                            <div class="form-group" v-show="wp.source.indexOf(parseInt(source))>-1 && wp.step.indexOf(parseInt(step))>-1">
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="位置" class="form-control" name="place">
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            {{--crrsp--}}
                            {{--catg--}}
                            <div class="form-group" v-show="crrsp.source.indexOf(parseInt(source))>-1 && crrsp.step.indexOf(parseInt(step))>-1">
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-6">
                                    <select class="form-control" name="category" id="category" required>
                                        <option v-for="c in cs" v-text="c.text" :value="c.val"></option>
                                    </select>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>
                            {{--results--}}
                            <div class="form-group" v-show="crrsp.source.indexOf(parseInt(source))>-1 && crrsp.step.indexOf(parseInt(step))>-1">
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-6">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="results" value="1" v-model="results"> Show results for
                                    </label>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>
                            <div class="form-group" v-show="crrsp.source.indexOf(parseInt(source))>-1 && crrsp.step.indexOf(parseInt(step))>-1 && results">
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="一级属性" class="form-control" name="first_attribute">
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>
                            <div class="form-group" v-show="crrsp.source.indexOf(parseInt(source))>-1 && crrsp.step.indexOf(parseInt(step))>-1 && results">
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="二级属性" class="form-control" name="second_attribute">
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>
                            {{--refine--}}
                            <div class="form-group" v-show="crrsp.source.indexOf(parseInt(source))>-1 && crrsp.step.indexOf(parseInt(step))>-1">
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-6">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="refine" value="1" v-model="refine"> Refine by
                                    </label>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>
                            <div class="form-group" v-show="crrsp.source.indexOf(parseInt(source))>-1 && crrsp.step.indexOf(parseInt(step))>-1 && refine">
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="attribute_group1"
                                           placeholder="属性类别1组">
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>
                            <div class="form-group" v-show="crrsp.source.indexOf(parseInt(source))>-1 && crrsp.step.indexOf(parseInt(step))>-1 && refine">
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="attribute1"
                                           placeholder="属性1组">
                                </div>
                            </div>
                            <div class="form-group" v-show="crrsp.source.indexOf(parseInt(source))>-1 && crrsp.step.indexOf(parseInt(step))>-1 && refine">
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="attribute_group2"
                                           placeholder="属性类别2组">
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>
                            <div class="form-group" v-show="crrsp.source.indexOf(parseInt(source))>-1 && crrsp.step.indexOf(parseInt(step))>-1 && refine">
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="attribute2"
                                           placeholder="属性2组">
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>
                            <div class="form-group" v-show="crrsp.source.indexOf(parseInt(source))>-1 && crrsp.step.indexOf(parseInt(step))>-1 && refine">
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="attribute_group3"
                                           placeholder="属性类别3组">
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>
                            <div class="form-group" v-show="crrsp.source.indexOf(parseInt(source))>-1 && crrsp.step.indexOf(parseInt(step))>-1 && refine">
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="attribute3"
                                           placeholder="属性3组">
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>
                            {{--sort--}}
                            <div class="form-group" v-show="crrsp.source.indexOf(parseInt(source))>-1 && crrsp.step.indexOf(parseInt(step))>-1">
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-6">
                                    <select class="form-control" name="sort_by" required>
                                        <option value="1">Price: Low to High</option>
                                        <option value="2">Price: High to Low</option>
                                        <option value="3">Avg. Customer Review</option>
                                        <option value="4">Newest Arrivals</option>
                                    </select>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>
                            {{--page--}}
                            <div class="form-group" v-show="crrsp.source.indexOf(parseInt(source))>-1 && crrsp.step.indexOf(parseInt(step))>-1">
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-6">
                                    <select class="form-control" name="page" required>
                                        <option value="1">1-3</option>
                                        <option value="2">4-9</option>
                                        <option value="3">10-20</option>
                                    </select>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            {{--ba--}}
                            <div class="form-group" v-show="ba.source.indexOf(parseInt(source))>-1 && ba.step.indexOf(parseInt(step))>-1">
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-6">
                                    <select class="form-control" name="ba_place" required>
                                        <option value="1">Frequently Bought Together</option>
                                        <option value="2">Sponsored Products Related To This Item</option>
                                        <option value="3">Customers Who Bought This Item Also Bought</option>
                                        <option value="4">Customers Also Shopped For</option>
                                        <option value="5">What Other Items Do Customers Buy After Viewing This Item?</option>
                                        <option value="6">Compare to Similar Items</option>
                                        <option value="7">customers who viewd this item also viewd</option>
                                    </select>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>
                            <div class="form-group" v-show="ba.source.indexOf(parseInt(source))>-1 && ba.step.indexOf(parseInt(step))>-1">
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="A产品ASIN" class="form-control" name="ba_asin" minlength="24" maxlength="24">
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">刷单件数</label>
                                <div class="col-md-6">
                                    <input type="number" placeholder="" class="form-control" name="task_num" required>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">刷单开始时间</label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="" class="form-control" name="start_time" id="start_time" required>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">刷单间隔</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="interval_time"
                                               placeholder="每单之间间隔分钟数" required>
                                        <div class="input-group-addon">分钟</div>
                                    </div>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">客户留言</label>
                                <div class="col-md-6">
                                    <div class="textarea">
                                        <textarea rows="3" class="form-control" name="customer_message" maxlength="300"></textarea>
                                    </div>
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
            data: {
                cs: [
                    {val: '0', text: '不选类别直接搜索'},
                    {val: '1', text: 'Alexa Skills'},
                    {val: '2', text: 'Amazon Video'},
                    {val: '3', text: 'Amazon Warehouse Deals'},
                    {val: '4', text: 'Appliances'},
                    {val: '5', text: 'Apps & Games'},
                    {val: '6', text: 'Arts, Crafts & Sewing'},
                    {val: '7', text: 'Automotive Parts & Accessories'},
                    {val: '8', text: 'Baby'},
                    {val: '9', text: 'Beauty & Personal Care'},
                    {val: '10', text: 'Books', selected: true},
                    {val: '11', text: 'CDs & Vinyl'},
                    {val: '12', text: 'Cell Phones & Accessories'},
                    {val: '13', text: 'Clothing, Shoes & Jewelry'},
                    {val: '14', text: 'Women'},
                    {val: '15', text: 'Men'},
                    {val: '16', text: 'Girls'},
                    {val: '17', text: 'Boys'},
                    {val: '18', text: 'Baby'},
                    {val: '19', text: 'Collectibles & Fine Art'},
                    {val: '20', text: 'Computers'},
                    {val: '21', text: 'Courses'},
                    {val: '22', text: 'Credit and Payment Cards'},
                    {val: '23', text: 'Digital Music'},
                    {val: '24', text: 'Electronics'},
                    {val: '25', text: 'Gift Cards'},
                    {val: '26', text: 'Grocery & Gourmet Food'},
                    {val: '27', text: 'Handmade'},
                    {val: '28', text: 'Health, Household & Baby Care'},
                    {val: '29', text: 'Home & Business Services'},
                    {val: '30', text: 'Home & Kitchen'},
                    {val: '31', text: 'Industrial & Scientific'},
                    {val: '32', text: 'Kindle Store'},
                    {val: '33', text: 'Luggage & Travel Gear'},
                    {val: '34', text: 'Luxury Beauty'},
                    {val: '35', text: 'Magazine Subscriptions'},
                    {val: '36', text: 'Movies & TV'},
                    {val: '37', text: 'Musical Instruments'},
                    {val: '38', text: 'Office Products'},
                    {val: '39', text: 'Patio, Lawn & Garden'},
                    {val: '40', text: 'Pet Supplies'},
                    {val: '41', text: 'Prime Pantry'},
                    {val: '42', text: 'Software'},
                    {val: '43', text: 'Sports & Outdoors'},
                    {val: '44', text: 'Tools & Home Improvement'},
                    {val: '45', text: 'Toys & Games'},
                    {val: '46', text: 'Vehicles'},
                    {val: '47', text: 'Video Games'},
                    {val: '48', text: 'Wine'},
                ],
                source:1,
                step:1,
                results:false,
                refine:false,
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