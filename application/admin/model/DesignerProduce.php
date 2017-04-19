<?php  
namespace app\admin\model;

class DesignerProduce extends Base
{
        
    public function showProduce($id)
    {
        return $this->where('designer_id',$id)->select();
    }

}