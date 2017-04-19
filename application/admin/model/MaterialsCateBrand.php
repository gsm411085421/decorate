<?php
/**
 * 主材分类、品牌关系
 */

namespace app\admin\model;

class MaterialsCateBrand extends Base
{
    public function brand()
    {
        return $this->hasOne('MaterialsBrand', 'id', 'brand_id')->field(true);
    }

    public function getByCate($cateId)
    {
        return self::with('brand')->where('cate_id', $cateId)->field(true)->select();
    }
}