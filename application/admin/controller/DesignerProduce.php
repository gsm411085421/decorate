<?php  
namespace app\admin\controller;

class DesignerProduce extends Base
{   
    protected $header = '设计师';
    /**
     * 作品集页面
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function index($id)
    {
        $this->view->desc = '作品列表' ;
        $data = parent::model()->showProduce($id);
        return $this->fetch('',['list'=>$data,'designer_id'=>$id]);
    }

    /**
     * 添加作品集
     */
    public function addProduce()
    {   
        if($this->request->isGet()){
            $designer_id = $this->request->param('designer_id'); 
        }
        return $this->fetch('',['designer_id'=>$designer_id]);
    }


}