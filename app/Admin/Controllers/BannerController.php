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
            $one = Banner::find($id);
            $content->body($this->form($one->type)->edit($id));
        });
    }

    public function form($type = 1)
    {
        return Admin::form(Banner::class, function (Form $form)use($type) {
            $form->radio('type','图片类型')->options(['1' => 'Banner(1920x600)', '2'=> 'Logo(100x50)'])->default('1')->rules('required');
            switch ($type){
                case 1:
                    $form->text('title', '图片标题')->default('banner')->rules('required');
                    $form->image('pic', '图片')->resize(1920, 600)->uniqueName()->move('banner')->rules('required|dimensions:min_width=1920,min_height=600');
                    break;
                case 2:
                    $form->text('title', '图片标题')->default('logo')->rules('required');
                    $form->image('pic', '图片')->resize(100, 50)->uniqueName()->move('banner')->rules('required|dimensions:min_width=100,min_height=50');

                    break;
            }
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
        return $this->form(request('type'))->store();
    }

    public function update($id)
    {
        Cache::forget('banners');
        Cache::forget('logo');
        $one = Banner::find($id);
        return $this->form($one->type)->update($id);
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