<?php
namespace app\admin\model;

class Estate extends Base
{
    protected $rule = [
        'name|楼盘名称' => 'require|max:25',
        'sorted|排序'   => 'between:0,255|number',
    ];
}