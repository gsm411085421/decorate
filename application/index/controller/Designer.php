<?php  
namespace app\index\controller;

class Designer extends Base
{
    public function designer()
    {   
        $data = parent::model()->getAll();
        return $this->fetch('',['designer'=>$data]);
    }
}