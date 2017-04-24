<?php
namespace app\index\controller;

use think\Loader;

class Index extends Base
{
    public function index()
    {   
        $data = Loader::model('ConfigImg')->getAll();
        return $this->fetch('',['configImg'=>$data]);
    }
}
