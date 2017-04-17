<?php
/**
 * wangEditor script 配置
 */
namespace app\admin\widget;

class WangEditor
{
    // 实例化的标签ID
    public static $htmlID    = 'editor';
    // 上传字段 name 
    public static $uploadFieldName = 'file';


    public function script($url = '', $id = '', $fieldName = '')
    {

        $url       = $url ?: url('Upload/wangEditor');
        $id        = $id ?: self::$htmlID;
        $fieldName = $fieldName ?: self::$uploadFieldName;
        return <<<WANG
        wangEditor.config.printLog = false;
        var editor = new wangEditor("$id");
        editor.config.uploadImgUrl = "$url";
        editor.config.uploadImgFileName = "$fieldName";
        editor.create();\n
WANG;
    }
}