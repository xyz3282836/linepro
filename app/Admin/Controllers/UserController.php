<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\Tools\TableType;
use App\Admin\Extensions\Tools\UserType;
use App\Http\Controllers\Controller;
use App\User;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

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
            $grid->model()->type(request('type', 0));
            $grid->id('ID')->sortable();
            $grid->name('用户名');
            $grid->email('Email');
            $grid->level_text('会员等级')->label('info');
            $grid->balance('余额(￥)')->editable();
            $grid->lock_balance('系统锁定余额(￥)');
            $grid->golds('金币(G)');
            $grid->lock_golds('系统锁定金币(G)');
            $grid->is_evaluate('可评价')->switch();
            $grid->validity('会员有效期');
            $grid->last_login_time('最后登入时间');
            $grid->created_at('注册时间');
            $grid->disableCreation();
            $grid->actions(function ($actions) {
                $actions->disableEdit();
            });
            $grid->tools(function ($tools) {
                $tools->append(new TableType(config('linepro.admin_user_level')));
            });
        });
    }

    protected function form()
    {
        return Admin::form(User::class, function (Form $form) {
            $form->text('balance', '余额')->rules('required');
            $form->text('is_evaluate', '可评价')->rules('required');
        });
    }

}
