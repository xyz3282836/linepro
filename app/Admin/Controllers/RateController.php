<?php
/**
 * Created by PhpStorm.
 * User: zhou
 * Date: 2017/6/22
 * Time: 下午3:14
 */

namespace App\Admin\Controllers;

use App\ExchangeRate;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class RateController extends Controller
{
    use ModelForm;

    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('header');
            $content->description('description');
            $content->body($this->grid());
        });
    }

    protected function grid()
    {
        return Admin::grid(ExchangeRate::class, function (Grid $grid) {
            $grid->id('ID');
            $grid->currency('货币');
            $grid->apiname('英文标识');
            $grid->name('符号标识');
            $grid->apirate('基准汇率');
            $grid->rate('使用汇率')->editable();
            $grid->updated_at('更新时间');
            $grid->disableFilter();
            $grid->disableExport();
            $grid->disablePagination();
            $grid->disableCreation();
            $grid->disableActions();
            $grid->disableRowSelector();//tools不能公用
        });
    }

    protected function form()
    {
        return Admin::form(ExchangeRate::class, function (Form $form) {
            $form->text('rate', '使用汇率')->rules('required');
        });
    }

}