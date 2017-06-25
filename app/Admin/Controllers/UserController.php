<?php

namespace App\Admin\Controllers;

use App\User;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class UserController extends Controller
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
        return Admin::grid(User::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->name('用户名');
            $grid->email('Email');
            $grid->level_text('会员等级')->label('info');
            $grid->balance('余额(￥)');
            $grid->golds('金币(G)');
            $grid->validity('会员有效期');
            $grid->last_login_time('最后登入时间');
            $grid->created_at('注册时间');
            $grid->disableCreation();
            $grid->actions(function ($actions) {
                $actions->disableEdit();
            });
        });
    }

}
