<?php
/**
 * 秒杀商品 时段存储
 */

namespace app\admin\model;

class GoodsSeckill extends Base
{
    public function time()
    {
        return $this->hasOne('GoodsSeckillTime', 'time_frame_id', 'id')->field('time_frame AS time');
    }

    public function addItems($goodsId, array $timeFrameId, array $activeData)
    {
        $this->where('goods_id', $goodsId)->delete();
        $data = [];
        for($i = 0; $i < count($timeFrameId); $i ++) {
            $data[] = ['goods_id'=> $goodsId, 'time_frame_id'=>$timeFrameId[$i], 'active_date'=>$activeData[$i]];
        }
        return $this->saveAll($data);
    }
}