<?php
/**
 * 上传控制器
 */
namespace app\common\controller;
use think\Request;
class Upload
{
    /**
     * 文件验证规则
     * @var array
     */
    protected $validateRule = [
        'image' => [
            'size' => 5242880, // 5M
            'ext'  => 'jpg,jpeg,png,gif,bmp'
        ],
        'file'  => [
            'size' => 5242880, // 5M
            'ext'  => 'pdf,txt,doc,docx,xls,xlsx'
        ],
    ];
    /**
     * 上传图片
     * @param  string $fieldName 表单字段 name
     * @return mixed
     */
    protected function image($fieldName = 'file')
    {
        $file = Request::instance()->file($fieldName);
        $info = $file->validate($this->validateRule['image'])
                ->move(ROOT_PATH. 'public'. DS. 'uploads');
        return $info ? $info : $file->getError();

        /*$file = Request::instance()->file($fieldName);
        $info = $file->validate($this->validateRule['image'])
                ->move(ROOT_PATH. 'public'. DS. 'uploads');
        if ($info) {
            $resData = [
                'info'     => $info->getInfo(),
                'filename' => $info->getFileName(),
                'savename' => $info->getSaveName()
            ];
            $res = ['code'=>1, 'msg'=>'上传成功', 'data'=>$resData];
        } else {
            $res = ['code'=>0, 'msg'=>$info->getError()];
        }
        return $res;*/
    }

    protected function file($fieldName=''){}
}