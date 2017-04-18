<?php
/**
 * 主材品牌系列
 */

namespace app\admin\model;

class MaterialsSeries extends Base
{
    protected $rule = [
        'brand_id|品牌 id' => 'require|number',
        'name|系列名称'    => 'require|max:20',
        'sorted|排序值'    =>  'between:0,255'
    ];

    public static function getAttributes()
    {
        return [
            'name' => ['label'=>'系列名称', 'type'=>'input', 'inputType'=>'text'],
            'sorted' => ['label'=>'排序值', 'type'=>'input', 'inputType'=>'number']
        ];
    }
}