<?php
/**
 * 楼盘
 */

namespace app\admin\controller;
use think\Loader;

class Estate extends Base
{
    
    protected $header = '楼盘';

    /**
     * 楼盘
     * @return [type] [description]
     */
    public function index ()
    {
        $this->view->desc = '楼盘列表';
        $data = parent::model()->getAll();
        return $this->fetch('', ['data'=>$data]);
    }

    /**
     * 楼盘编辑
     * @return [type] [description]
     */
    public function estateEdit ()
    {
        if ($this->request->isGet()){
            return parent::model()->getOne($this->request->get('id'));
        } else {
            return parent::model()->edit();
        }
    }

    /**
     * 删除
     * @return [type] [description]
     */
    public function estateDeleteOne ()
    {
        return parent::model()->deleteOne($this->request->post('id'));
    }

    /**
     * 设置显示状态
     * @return [type] [description]
     */
    public function estateStatus()
    {
        $post = $this->request->post();
        return parent::model('Estate')->setStatus($post['value'], ['id'=>$post['id']]);
    }

    ///户型///
    
    function apartmentLayout ()
    {
        $estateId = $this->request->param('pid');
        $this->view->desc = '户型列表';
        $data = parent::model('ApartmentLayout')->getAll();
        return $this->fetch('apartmentLayout', ['data'=>$data]);
    }
}