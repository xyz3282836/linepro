<?php
/**
 * Created by PhpStorm.
 * User: zhou
 * Date: 2017/6/22
 * Time: 下午3:14
 */

namespace App\Admin\Controllers;

use App\Gconfig;
use App\Http\Controllers\Controller;
use Cache;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class ConfigController extends Controller
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
        return Admin::grid(Gconfig::class, function (Grid $grid) {
            $grid->key('标识')->label('danger');
            $grid->desc('描述');
            $grid->value('值')->editable();
            $grid->actions(function ($actions) {
                $actions->disableDelete();
            });
            $grid->tools(function ($tools) {
                $tools->batch(function ($batch) {
                    $batch->disableDelete();
                });
            });
        });
    }

    public $id = 0;

    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form()->edit($id));
        });
    }

    protected function form()
    {
        return Admin::form(Gconfig::class, function (Form $form) {
            $form->display('key', '标识')->rules('required');
            $form->display('desc', '描述')->rules('required');
            $form->text('value', '值')->rules('required');
            $form->saving(function ($form) {

            });
        });
    }

    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form());
        });
    }
}