<?php  
namespace app\admin\controller;

class ConfigImg extends Base{

    protected $header = '系统配置' ;

    public function index()
    {   
        $this->view->desc = '轮播图设置';
        $data = parent::model()->getAll();
        return $this->fetch('',['list'=>$data]);
    }

    /**
     * 添加轮播图片信息
     */
    public function addConfigImg()
    {
        $this->view->desc = '添加图片';
        if($this->request->isPost()){
            $input = $this->request->post();
            return parent::model()->edit($input);
        }
        return $this->fetch();
    }

    /**
     * 编辑轮播图片
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function editConfigImg($id)
    {   
        $this->view->desc = '编辑图片';
        if($this->request->isPost()){
            $input = $this->request->post();
            return parent::model()->edit($input);
        }
        $data = parent::model()->getOne($id);
        return $this->fetch('',['list'=>$data]);
    }

    /**
     * 删除一张图片信息
     * @return [type] [description]
     */
    public function delete()
    {
        if($this->request->isPost()){
            $id = $this->request->param('id');
            return parent::model()->deleteOne($id);
        }
    }

}