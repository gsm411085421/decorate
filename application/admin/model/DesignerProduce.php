<?php  
namespace app\admin\model;

use think\Loader;

class DesignerProduce extends Base
{
    
     protected $pageSize = 20;

    /**
     * 根据设计者id查询作品集
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function showProduce(array $where,$pageSize = null,$config)
    {   
        $pageSize = $pageSize ? : $this->pageSize;
        return $this->where($where)->field(true)->paginate($pageSize,false,$config);
    }

    /**
     * 删除作品集和作品集下的图片
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function deleteProduce($id){
        $data1 = self::deleteOne($id);
        $data2 = Loader::model('DesignerProduceImg')->deleteByProduceId($id);
        if(isset($data1) && isset($data2)){
            return ['code'=>1,'msg'=>'删除成功'];
        }else{
            return ['code'=>0,'msg'=>'删除失败'];
        } 
    }

    /**
     * 根据设计者id删除作品集
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function deleteByDesignerId($id)
    {
        return $this->field(true)->where('designer_id',$id)->delete();
    }




}