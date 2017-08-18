<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\Tools\TableType;
use App\Http\Controllers\Controller;
use App\Order;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class OrderController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->grid());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Order::class, function (Grid $grid) {
            $grid->model()->type(request('type', 0));
            $grid->id('ID')->sortable();
            $grid->uid('用户ID');
            $grid->type_text('订单类型')->label('info');
            $grid->orderid('订单号');
            $grid->alipay_orderid('支付宝订单号');
            $grid->golds('金币');
            $grid->price('共计');
            $grid->balance('余额支付');
            $grid->pay('充值支付');
            $grid->status_text('订单状态')->label('warning');
            $grid->created_at('订单创建时间');
            $grid->disableCreation();
            $grid->disableActions();
            $grid->disableRowSelector();//tools不能公用

            $grid->filter(function ($filter) {
                $filter->is('orderid', '订单号');
                $filter->is('uid', '用户id');
                $filter->is('alipay_orderid', '支付宝订单号');
            });

            $grid->tools(function ($tools) {
                $tools->append(new TableType(config('linepro.admin_order_type')));
            });
        });
    }
}
