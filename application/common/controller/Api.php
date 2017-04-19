<?php
/**
 * 
 */
namespace app\common\controller;

use think\Db;

class Api
{
    public function getBrand($cateId)
    {
        $field = 'b.id, b.name';
        return Db::name('MaterialsCateBrand')->alias('cb')
                ->join('tp_materials_brand b', 'cb.brand_id = b.id')
                ->where('cb.cate_id', $cateId)
                ->field($field)
                ->order('b.sorted')
                ->select();
    }

    public function getSeries($brandId)
    {
        $field = 'id, name';
        return Db::name('MaterialsSeries')->where('brand_id', $brandId)->field($field)->select();
    }
}