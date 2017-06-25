<?php
/**
 * Created by PhpStorm.
 * User: zhou
 * Date: 2017/6/23
 * Time: 上午10:32
 */

namespace App\Admin\Controllers;


use App\Banner;
use App\Http\Controllers\Controller;
use Cache;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class BannerController extends Controller
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
        return Admin::grid(Banner::class, function (Grid $grid) {
            $grid->type_text('类型')->label('info');
            $grid->title('图片标题');
            $grid->pic('图片')->image();
            $grid->created_at('创建时间');
        });
    }

    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->header('header');
            $content->description('description');
            $content->body($this->form()->edit($id));
        });
    }

    public function form()
    {
        return Admin::form(Banner::class, function (Form $form) {
            $form->text('title', '图片标题');
            $form->image('pic', '图片')->uniqueName()->move('banner')->rules('required');

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
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

    public function store()
    {
        Cache::forget('banners');
        Cache::forget('logo');
        return $this->form()->store();
    }

    public function update($id)
    {
        Cache::forget('banners');
        Cache::forget('logo');
        return $this->form()->update($id);
    }

    public function destroy($id)
    {
        if ($this->form()->destroy($id)) {
            Cache::forget('banners');
            return response()->json([
                'status'  => true,
                'message' => trans('admin::lang.delete_succeeded'),
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => trans('admin::lang.delete_failed'),
            ]);
        }
    }

}