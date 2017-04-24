<?php
namespace app\index\model;

class Materials extends Base
{
    public function getAllMaterials ($param)
    {
        $where = ['status'=>1];
        if (isset($param['cate_id']) && $param['cate_id'] != 0) {
            $where = array_merge($where, ['cate_id'=>$param['cate_id']]);
        }
        if (isset($param['brand_id']) && $param['brand_id'] != 0){
            $where = array_merge($where, ['brand_id'=>$param['brand_id']]);
        }
        if (isset($param['series_id']) && $param['series_id'] != 0) {
            $where  = array_merge($where, ['series_id'=>$param['series_id']]);
        }
        return $this->field(true)->where($where)->select();
    }
}