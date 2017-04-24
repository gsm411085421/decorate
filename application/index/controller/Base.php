<?php

namespace app\index\controller;

use app\common\controller\Base as BaseController;
use app\common\api\SystemConfig;

class Base extends BaseController
{

    protected function _initialize()
    {
        $this->usInfo();
    }


    public function usInfo()
    {
        $systemConfig = new SystemConfig();
        $data = $systemConfig->data();
        $this->view->assign('usInfo',$data);
    }

}