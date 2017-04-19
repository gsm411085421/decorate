<?php  
namespace app\admin\controller;

class DesignerProduceImg extends Base
{   

    protected $header = '设计师';

    public function index($id)
    {   
        $this->view->desc = '作品图片' ;
        $data = parent::model()->showImg($id);
        return $this->fetch('',['list'=>$data]);
    }
}