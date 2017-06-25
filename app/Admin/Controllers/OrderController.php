<?php

namespace App\Admin\Controllers;

use App\Order;

use App\User;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

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

            $grid->id('ID')->sortable();
            $grid->uid('用户ID');
            $grid->type_text('订单类型')->label();
            $grid->orderid('订单号');
            $grid->alipay_orderid('支付宝订单号');
            $grid->golds('金币');
            $grid->price('共计');
            $grid->balance('余额支付');
            $grid->pay('充值支付');
            $grid->status_text('订单状态')->label();
            $grid->created_at('订单创建时间');
            $grid->disableCreation();
            $grid->disableActions();
            $grid->disableRowSelector();//tools不能公用

            $grid->filter(function($filter){
                $filter->is('orderid', '订单id');
                $filter->is('uid', '用户id');
                $filter->is('alipay_orderid', '支付宝订单号');
            });
        });
    }
}
