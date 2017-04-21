<?php
namespace app\admin\model;

class UsageArea extends Base
{
    protected $rule = [
        'name|区域名称' => 'require|max:25',
        'sorted|排序'   => 'between:0,255',
    ];
}