<?php  
namespace app\admin\model;

class Designer extends Base
{     
    protected $pageSize = 20;

    protected $auto = ['update_at'];
    /**
     * 显示设计者
     * @param  array   $where    [description]
     * @param  integer $pageSize [description]
     * @param  array   $config   [description]
     * @return [type]            [description]
     */
    public function showDesigner(array $where,$pageSize=null,array $config)
    {   
        $pageSize = $pageSize ? : $this->pageSize;
        return $this->where($where)->field(true)->paginate($pageSize,false,$config);
    }
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

    public function setUpdateAtAttr($value)
    {
        return date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
    }

}