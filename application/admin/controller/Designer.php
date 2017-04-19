<?php  
namespace app\admin\controller;

class Designer extends Base
{   
    protected $header = '设计师';

    /**
     * 设计师页面
     * @return [type] [description]
     */
    public function index()
    {   
        $this->view->desc = '设计师' ;
        $where = $config = [];
        $data = parent::model()->getPaginate($where,$config);
        return $this->fetch('',['list'=>$data]);
    }

    /**
     * 添加设计师信息
     */
    public function addDesigner()
    {    
        if($this->request->isPost()){
            $input = $this->request->post(); 
            return parent::model()->edit($input);
        }
        return $this->fetch('addDesigner'); 
    }

     /**
     * 编辑设计师信息
     */
    public function editDesigner($id)
    {    
        $data = parent::model()->getOne($id);
        if($this->request->isPost()){
            $input = $this->request->post(); 
            return parent::model()->edit($input);
        }
        return $this->fetch('editDesigner',['list'=>$data]); 
    }

    /**
     * 删除设计师
     * @return [type] [description]
     */
    public function deleteDesigner()
    {
        if($this->request->isPost()){
            $id = $this->request->param('id');
            return parent::model()->deleteOne($id);
        }
    }

    /**
     * 切换设计师状态
     * @return [type] [description]
     */
    public function changeStatus()
    {
        if($this->request->isPost()){
            $input = $this->request->post();
            return parent::model()->setStatus($input['status'],['id'=>$input['id']]);
        }
    }

}