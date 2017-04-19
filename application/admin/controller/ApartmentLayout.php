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

    /**
     * 区域
     * @return [type] [description]
     */
    public function usageArea ()
    {
        $data = parent::model('UsageArea')->getAll();
        $this->view->desc = '使用区域';
        return $this->fetch('usageArea', ['data'=>$data]);
    }

    /**
     * 使用区域编辑
     * @return [type] [description]
     */
    public function usageEdit()
    {
        if ($this->request->isGet()){
            return parent::model('UsageArea')->getOne($this->request->get('id'));
        } else {
            return parent::model('UsageArea')->edit();
        }
    }

    /**
     * 删除
     * @return [type] [description]
     */
    public function usageDeleteOne ()
    {
        return parent::model('UsageArea')->deleteOne($this->request->post('id'));
    }

    /**
     * 设置显示状态
     * @return [type] [description]
     */
    public function usageStatus()
    {
        $post = $this->request->post();
        return parent::model('UsageArea')->setStatus($post['value'], ['id'=>$post['id']]);
    }
}