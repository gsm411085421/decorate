<?php
namespace app\admin\controller;

use app\common\controller\Upload as BaseUpload;
use think\Request;

class Upload extends BaseUpload
{
    /**
     * 图片上传
     * @param  string $fieldName 表单字段 name
     * @return json
     */
    public function image($fieldName = 'file')
    {
        $info = parent::image($fieldName);
        if (!is_string($info)) {
            $data = [
                'info'     => $info->getInfo(),
                'filename' => $info->getFileName(),
                'savename' => $info->getSaveName()
            ];
            $res = ['code'=>1, 'data'=>$data];
        } else {
            $res = ['code'=>0, 'msg'=>$info ? : '上传失败了'];
        }
        return $res;
    }

    /**
     * wangEditor 图片上传
     * @param  string $file 表单字段名
     * @return
     */
    public function wangEditor($file = 'file')
    {
        $file = Request::instance()->file($file);
        $info = $file->validate($this->validateRule['image'])->move(ROOT_PATH. 'public'. DS. 'uploads');
        if ($info) {
            $fileUrl = $info->getSaveName();
            echo '/uploads/'.str_replace('\\', '/', $fileUrl);
        } else {
            echo 'error|'.$file->getError();
        }
    }
}