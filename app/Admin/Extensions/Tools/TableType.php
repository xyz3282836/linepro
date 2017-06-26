<?php
/**
 * Created by PhpStorm.
 * User: zhou
 * Date: 2017/6/26
 * Time: 下午5:20
 */

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;
use Illuminate\Support\Facades\Request;

class TableType extends AbstractTool
{
    public function __construct($option)
    {
        $this->option = $option;
    }

    private $option = null;

    public function render()
    {
        Admin::script($this->script());

        $options = $this->option;

        return view('admin.tools.table_type', compact('options'));
    }

    public function script()
    {
        $url = Request::fullUrlWithQuery(['type' => '_type_']);

        return <<<EOT

$('input:radio.table-type').change(function () {

    var url = "$url".replace('_type_', $(this).val());

    $.pjax({container:'#pjax-container', url: url });

});

EOT;
    }
}