<?php
/**
 * 商品价格
 */

namespace app\admin\model;

class GoodsPrice extends Base
{   
    /**
     * 添加商品价格
     * @param int $goodsId 商品 id
     * @param array  $name    索引数组 套餐名
     * @param array  $price   价格
     * @param array  $store   库存
     */
    public function addItems($goodsId, array $name, array $price, array $store)
    {
        $this->where('goods_id', $goodsId)->delete();
        $data = [];
        for ($i = 0; $i < count($name); $i ++) {
            $data[] = ['goods_id'=>$goodsId, 'spec_name'=>$name[$i], 'price'=>$price[$i], 'inventory'=>$store[$i]];
        }
        return $this->saveAll($data);
    }


}