<?php
namespace App\Admin\Controllers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * 处理文件上传 给wangEditor使用
     *
     * @param Request $request
     * @return string
     */
    public function upload(Request $request)
    {
        if ($request->hasFile('eimg') && $request->file('eimg')->isValid()) {
            $file = $request->file('eimg');
            //扩展名
            $extension = $file->extension();
            //允许的文件后缀
            $fileTypes = array('jpeg', 'png');
            //检查类型是否支持
            if (! in_array($extension, $fileTypes)) {
                return response($this->error(1));
            }
            //检查文件大小是否超过php.ini的设置
            if ($file->getMaxFilesize() < $file->getClientSize()) {
                return response($this->error(2));
            }
            $filename = time() . rand(100000, 999999) . '.' . $extension;
            $file->move('../public/upfile/admin/editor/', $filename);
            $fullname = '/upfile/admin/editor/' . $filename;
            return response()->json($this->success($fullname));
        } else {
            return response($this->error(3));
        }
    }

    private function success($picurl){
        return [
            'errno'=>0,
            'data'=>[$picurl]
        ];
    }

    private function error($code){
        return [
            'errno'=>$code,
        ];
    }
}