<?php
/**
 * 秒杀时段配置
 */

namespace app\admin\model;

class GoodsSeckillTime extends Base
{
    protected $rule = [
        'time_frame|时段' => ['require','unique'=>'GoodsSeckillTime','dateFormat'=>'H:i']
    ];

    public function getTimeFrameAttr($value)
    {
        return substr($value, 0, 5);
    }

    public function selectAll()
    {
        return $this->field('id,time_frame')->order('time_frame')->select();
    }

    /**
     * 删除时段
     * @param  int $id 
     * @return array
     */
    public function deleteItem($id)
    {
        if ($this->_canDelete($id)) {
            if ($this->where('id', $id)->delete()) {
                $res = success();
            } else {
                $res = error();
            }
            return $res;
        } else {
            return error('当前已被使用，不可被删除');
        }
    }

    /**
     * 是否可被 删除 TODO::
     * @param  int $id
     * @return boolean
     */
    private function _canDelete($id)
    {
        return true;
    }
}