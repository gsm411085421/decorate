<?php
/**
 * 商品模型
 */

namespace app\admin\model;

class GoodsModel extends Base
{
    protected $rule = [
        'name|模型名称' => 'max:25|unique:GoodsModel'
    ];

    
}