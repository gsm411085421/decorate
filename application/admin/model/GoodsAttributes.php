<?php
/**
 * 商品属性
 */

namespace app\admin\model;

class GoodsAttributes extends Base
{
    protected $goods_id;

    public function addItems($goodsId, array $attr)
    {
        $data = [];
        $this->where('goods_id', $goodsId)->delete();
        foreach ($attr as $attrId => $attrValue) {
            $data[] = ['goods_id'=>$goodsId, 'attr_id'=>$attrId, 'value'=>$attrValue];
        }
        return $this->saveAll($data);
    }

}