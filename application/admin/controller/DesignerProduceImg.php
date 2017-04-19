<?php  
namespace app\admin\controller;

class DesignerProduceImg extends Base
{   

    protected $header = '设计师';

    /**
     * 作品图片页面
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function index($id)
    {   
        $this->view->desc = '作品图片' ;
        $data = parent::model()->showImg($id);
        return $this->fetch('',['list'=>$data,'produce_id'=>$id]);
    }

    /**
     * 添加图片页面
     * @param [type] $produce_id [description]
     */
    public function addImg($produce_id)
    {   
        $this->view->desc = '添加作品集图片' ;
        if($this->request->isPost()){
            $input = $this->request->post();
            return parent::model()->edit($input);
        }
        return $this->fetch('',['produce_id'=>$produce_id]);
    }

    /**
     * 编辑图片页面
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function editImg($id)
    {   
        $this->view->desc = '编辑作品集图片' ;
        $data = parent::model()->getOne($id);
        if($this->request->isPost()){
            $input = $this->request->post();
            return parent::model()->edit($input);
        }
        return $this->fetch('',['list'=>$data]);
    }

    /**
     * 删除图片
     * @return [type] [description]
     */
    public function deleteImg()
    {
        if($this->request->isPost()){
            $id = $this->request->param('id');
            return parent::model()->deleteOne($id);
        }
    }

}