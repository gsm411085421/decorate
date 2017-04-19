<?php  
namespace app\admin\model;

class Designer extends Base
{   
    /**
     * 关联作品集表
     * @return [type] [description]
     */
    public function produceDesigner()
    {
        return $this->hasMany('DesignerProduce','designer_id','id')->field('id,designer_id,name,introduce');
    }

    /**
     * 查询对应Id的所有作品级
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function showDesignerProduce($id){
        $data = self::with('produceDesigner')->where('id',$id)->select();
        return collection($data)->toArray();
    }
}