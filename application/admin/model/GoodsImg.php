<?php
/**
 * 商品图片
 */

namespace app\admin\model;

class GoodsImg extends Base
{
    public function addItems($goodsId, array $imgs)
    {
        $this->where('goods_id', $goodsId)->delete();
        $data = [];
        foreach ($imgs as $v) {
            $data[] = ['goods_id'=>$goodsId, 'src'=>$v];
        }
        return $this->saveAll($data);
    }
}