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
        $data = parent::model()->getAll();
        return $this->fetch('', ['data'=>$data]);
    }

    /**
     * 更改字段值
     * @return [type] [description]
     */
    public function updateField ()
    {
        return parent::model('ApartmentLayout')->updateField();
    }
}