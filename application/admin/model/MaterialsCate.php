<?php
/**
 * 主材分类
 */

namespace app\admin\model;

class MaterialsCate extends Base
{
    protected $rule = [
        'cate_name|分类名称' => 'require|max:15|unique:MaterialsCate',
        'sorted|排序值'      => 'between:0,255',
        'status|状态'        => 'in:0,1'
    ];

    public static function getAttributes()
    {
        return [
            'cate_name' => ['label'=>'分类名称', 'type'=>'input', 'inputType'=>'text', 'attr'=>['placeholder'=>'输入分类名称']],
            'sorted' => ['label'=>'排序值', 'type'=>'input', 'inputType'=>'number'],
        ];
    }
}