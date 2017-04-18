<?php  
namespace app\admin\controller;

class Designer extends Base
{   
    protected $header = '设计师';

    public function index()
    {   
        $this->view->desc = '设计师' ;
        return $this->fetch();
    }
}