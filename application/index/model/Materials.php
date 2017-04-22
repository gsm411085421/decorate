<?php
namespace app\index\model;

class Materials extends Base
{
    public function getAllMaterials ($param)
    {
        $where = ['status'=>1];
        if (isset($param['cate_id'])) {
            $where = array_merge($where, ['cate_id'=>$param['cate_id']]);
        }
        if (isset($param['brand_id'])){
            $where = array_merge($where, ['brand_id'=>$param['brand_id']]);
        }
        return $this->field(true)->where($where)->select();
    }
}