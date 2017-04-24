<?php
/**
 * 户型
 */

namespace app\admin\controller;

class Layout extends Base
{
    protected $header = '楼盘管理';

    protected $table = 'Layout';

    public function index()
    {
        /** @var int 楼盘 ID */
        $estateId = $this->request->param('estate_id');

        $data = parent::model()->getAll(['estate_id'=>$estateId]);

        $this->view->desc = '户型列表';
        return $this->fetch('', [
            'estateId' => $estateId,
            'data'     => $data
        ]);
    }

    public function edit()
    {
        $request = $this->request;
        $estateId = $request->param('estate_id');

        if ($request->isPost()) {
            return parent::model()->edit($request->post());
        }

        $detail = [];
        if ($request->isGet() && $request->has('id') && $id = $request->param('id')) {
            $detail = parent::model()->getOne($id);
        }

        $this->view->desc = '编辑户型';
        return $this->fetch('', [
            'exists'   => !empty($detail),
            'detail'   => $detail,
            'estateId' => $estateId
        ]);
    }

    /**
     * 户型属性
     * @return [type] [description]
     */
    public function layoutAttr ()
    {
        $layoutId        = $this->request->param('layout_id');
        $layoutAttrModel = parent::model('LayoutAttr');
        $layoutModel     = parent::model('Layout');

        $layoutData = $layoutModel->getOne($layoutId);
        $layoutAttrData = $layoutAttrModel->getDataByType($layoutId);
        $this->view->desc = '户型属性';
        return $this->fetch('layoutAttr', [
                'layoutAttrData' => $layoutAttrData,
                'layoutData'     => $layoutData,
                'type'           => $layoutModel->type,
                'layout_id'      => $layoutId,
            ]);
    }

    /**
     * 编辑户型属性
     * @return [type] [description]
     */
    public function layoutAttrEdit ()
    {
        if ($this->request->isPost()){
            $data = $this->request->post();
            return parent::model('LayoutAttr')->layoutAttrEdit($data);
        } else {
            return ['code'=>0, 'msg'=>'非法提交'];
        }
    }

    /**
     * 删除户型
     * @return [type] [description]
     */
    public function layoutDelete ()
    {
        return parent::model('Layout')->deleteOne($this->request->post('id'));
    }
}