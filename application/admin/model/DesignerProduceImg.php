<?php  
namespace app\admin\model;

class DesignerProduceImg extends Base
{
    public function showImg($id)
    {
        return $this->where('produce_id',$id)->select();
    }

}