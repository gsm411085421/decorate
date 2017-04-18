<?php
/**
 * 户型
 */

namespace app\admin\controller;

class ApartmentLayout extends Base
{
    protected $header = '户型';

    public function index ()
    {
        $this->view->desc = '户型列表';
        return $this->fetch();
    }
}