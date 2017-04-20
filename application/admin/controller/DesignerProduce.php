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
        $where['designer_id']= $id;
        $config = [];
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
        $data = parent::model()->showProduce($where,null,$config);
        return $this->fetch('',['list'=>$data,'designer_id'=>$id]);
    }

    /**
     * 添加作品集
     * @param [type] $designer_id [description]
     */
    public function addProduce($designer_id)
    {   
        $this->view->desc = '添加作品集' ;
        if($this->request->isPost()){
            $input = $this->request->post();
            return parent::model()->edit($input);
        }
        return $this->fetch('',['designer_id'=>$designer_id]);
    }

    /**
     * 编辑作品集
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function editProduce($id)
    {   
        $this->view->desc = '编辑作品集' ;
        $data = parent::model()->getOne($id);
        if($this->request->isPost()){
            $input = $this->request->post();
            return parent::model()->edit($input);
        }
        return $this->fetch('',['list'=>$data]);
    }

    /**
     * 切换作品集状态
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function changeStatus()
    {
        if($this->request->isPost()){
            $input = $this->request->post();
            return parent::model()->setStatus($input['status'],['id'=>$input['id']]);
        }
    }

    /**
     * 删除作品集和作品集下的图片
     * @return [type] [description]
     */
    public function deleteProduce()
    {
        if($this->request->isPost()){
            $id = $this->request->param('id');
            return self::model()->deleteProduce($id);
        }
    }

}