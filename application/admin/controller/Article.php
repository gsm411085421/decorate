<?php
namespace app\admin\controller;

class Article extends Base
{
    protected $header = '文章管理';
/**
 * 文章列表
 * @return [type] [description]
 */
    public function index()
    {
        $this->view->desc = '文章列表';
        $data = parent::model()->getPage();
        return $this->fetch('', ['data'=>$data]);
    }

/**
 * 回收站
 * @return
 */
    public function trash()
    {
        $this->view->desc = '回收站';
        $data = parent::model()->getPageOnlyTrash();
        return $this->fetch('', ['data'=>$data]);
    }
/**
 * 新建
 * @return
 */
    public function create()
    {
        if ($this->request->isPost()) {
            $input = $this->request->post();
            $input['content'] = $this->request->post('content',null,'');

            return parent::model()->addItem($this->uid, $input);
        }
        $this->view->desc = '新建文章';
        return $this->fetch();
    }
/**
 * 编辑
 * @return
 */
    public function edit()
    {
        if ($this->request->isPost()) {
            $input = $this->request->post();
            $input['content'] = $this->request->post('content',null,'');

            return parent::model()->editItem($this->uid, $input);
        }
        $id = $this->request->param('id');
        $this->view->desc = '编辑文章';
        $detail = parent::model()->getOne($id);
        $detail->cover = str_replace('\\', '/', $detail->cover );

        return $this->fetch('', ['detail'=>$detail]);
    }
/** 删除文章封面图 */
    public function deleteCover()
    {
        return ['code'=>1];
    }
/**
 * 修改状态
 */
    public function setStatus()
    {
        $input = $this->request->post();
        $value = intval($input['status']);
        $id    = $input['id'];
        return parent::model()->setStatus($value, ['id'=>$id]);
    }
/**
 * 加入回收站
 */
    public function addToTrash()
    {
        $input = $this->request->post();
        $id    = $input['id'];
        return parent::model()->softDelete($id);
    }
/**
 * 从回收站恢复
 */
    public function restore()
    {
        $input = $this->request->post();
        $id    = $input['id'];
        return parent::model()->restoreFromTrash($id);
    }
/**
 * 真实删除
 * @return [type] [description]
 */
    public function delete()
    {
        $input = $this->request->post();
        return parent::model()->deleteOne($input['id']);
    }
}