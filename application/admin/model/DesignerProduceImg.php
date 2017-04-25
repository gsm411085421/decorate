<?php  
namespace app\admin\model;

class DesignerProduceImg extends Base
{   

    protected $rule = [
        'img_url'=>'require'
    ];

    protected $message = [
        'img_url.require' => '请先上传图片'
    ];

    /**
     * 根据作品集id查询图片
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function showImg($id)
    {
        return $this->field(true)->where('produce_id',$id)->select();
    }

    /**
     * 根据作品集id删除作品集
     * @return [type] [description]
     */
    public function deleteByProduceId($produce_id){
        return $this->where('produce_id',$produce_id)->delete();
    }

}