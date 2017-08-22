<?php
/**
 * Created by PhpStorm.
 * User: zhou
 * Date: 2017/8/22
 * Time: 下午1:24
 */

namespace App\Admin\Extensions\Form;

use Encore\Admin\Form\Field;

class WangEditor extends Field
{
    protected static $css = [
        '/packages/admin/wangEditor/wangEditor.min.css',
    ];
    protected static $js = [
        '/packages/admin/wangEditor/wangEditor.min.js',
    ];
    protected $view = 'admin::form.wangeditor';

    protected $menuOption;

    public function render()
    {
        $name = $this->formatName($this->column);

        $this->script = <<<EOT
        var E = window.wangEditor
        var editor = new E('#{$this->id}');
        editor.customConfig.onchange = function (html) {
            $('input[name=$name]').val(html);
        }
        {$this->getUploadScript()}
        editor.create()
EOT;
        return parent::render();
    }


    /**
     * WangEditor constructor.
     *
     */
    public function __construct($column, $arguments = [])
    {
        parent::__construct($column, $arguments = []);
        $this->menuOption = config("linepro.editor_menu");
    }


    /**
     * 自定义编辑器菜单
     *
     * 用户可以调用该方法为每次使用编辑器的地方单独进行菜单配置
     *
     * @param $menuOption
     */
    public function menu($menuOption)
    {
        $this->menuOption = $menuOption;
    }
    private function csrf()
    {
        return csrf_token();
    }
    private function getMenuScript()
    {
        if ($this->menuOption != null) {
            $menuOption = json_encode($this->menuOption);
            return <<<EOT
            // 普通的自定义菜单
            editor.customConfig.menus = JSON.parse('$menuOption');
EOT;
        }
        return '';
    }
    private function getUploadScript()
    {
        if (in_array('img',$this->menuOption)) {
            return $this->defaultUploadScript();
        } else {
            return "";
        }
    }
    /**
     * 本地上传图片使用
     *
     * @return string
     */
    private function defaultUploadScript()
    {
        return <<<EOT
    // 上传图片
    editor.customConfig.uploadImgServer = "{$this->getimgurl()}";
    editor.customConfig.uploadImgMaxSize = 2 * 1024 * 1024
    editor.customConfig.uploadImgMaxLength = 1
    editor.customConfig.uploadFileName = 'eimg'
    editor.customConfig.uploadImgParams = {
        _token: '{$this->csrf()}'
    }
    editor.customConfig.uploadHeaders = {
        'X-CSRF-TOKEN' : "{$this->csrf()}"
    };
EOT;
    }


    private function getimgurl(){
        return admin_url('upload');
    }




}