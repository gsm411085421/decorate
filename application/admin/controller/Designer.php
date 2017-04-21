<?php  
namespace app\admin\controller;

use think\Loader;

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
        if($this->request->isGet() && $this->request->has('query')){
            $get = $this->request->get();
            if(isset($get['status']) && $get['status'] != -1 ){
                $where['status'] = $config['query']['status'] = $get['status'];
            }
            if(isset($get['search'])){
                $where['name'] = ['like','%'.$get['search'].'%'];
                $config['query']['search'] = $get['search'];
            }
        }
        $data = parent::model()->showDesigner($where,null,$config);
        return $this->fetch('',['list'=>$data]);
    }

    /**
     * 添加设计师信息
     */
    public function addDesigner()
    {    
        $this->view->desc = '添加设计师' ;
        if($this->request->isPost()){
            $input = $this->request->post(); 
            return parent::model()->edit($input);
        }
        return $this->fetch(''); 
    }

     /**
     * 编辑设计师信息
     */
    public function editDesigner($id)
    {    
        $this->view->desc = '编辑设计师' ;
        $data = parent::model()->getOne($id);
        if($this->request->isPost()){
            $input = $this->request->post(); 
            return parent::model()->edit($input);
        }
        return $this->fetch('',['list'=>$data]); 
    }

    /**
     * 删除设计师、作品集、图片
     * @return [type] [description]
     */
    public function deleteDesigner()
    {
        if($this->request->isPost()){
            $id = $this->request->param('id');
            $deleteDesigner = Loader::model('DesignerProduce');
            $data1 = self::model()->showDesignerProduce($id);
            $produce = $data1[0]['produce_designer'];
            foreach ($produce as $key => $value) {
                $deleteDesigner->deleteProduce($value['id']);
            }
            return parent::model()->deleteOne($id);;
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