<?php
namespace app\admin\validate;

use think\Validate;

class Article extends Validate
{
    protected $rule = [
        'title'   => 'require|length:2,50',
        'summary' => 'max:512',
        'content' => 'require',
        'cover'   => 'max:64',
        'tags'    => 'max:64'
    ];

    protected $message = [
        'title.require'   => '标题未填写',
        'title.length'    => '标题字数介于 2 到 50',
        'summary.max'     => '摘要不能超过 500 个字',
        'content.require' => '没有文章内容',
        'cover.max'       => '封面路径不能超过 64 个字符',
        'tags.max'        => '标签不能超过 64 个字符'
    ];
}