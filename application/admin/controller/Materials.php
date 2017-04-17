<?php
namespace app\admin\controller;

use fengniao\render\FormActive;
use think\Db;

class Materials extends Base
{
    protected $header = '主材管理';

    public function index()
    {
        $this->view->desc = '主材列表';
        return $this->fetch();
    }

    ////////
    // 分类 //
    ////////
    /**
     * 分类列表 
     * @return [type] [description]
     */
    public function cate()
    {
        $model = parent::model('MaterialsCate');
        $this->view->desc = '主材分类';
        return $this->fetch('', [
            'data' => $model->getAll(),
        ]);
    }

    /**
     * 分类编辑
     * @return [type] [description]
     */
    public function cateEdit()
    {
        $model = parent::model('MaterialsCate');
        $request = $this->request;
        if ($request->isPost()) {
            // status 特殊处理
            $post = $request->post();
            !isset($post['status']) && $post['status'] = 0;
            return $model->edit($post);
        }
        $detail = [];
        if ($request->has('id') && $id = $request->param('id')) {
            $detail = $model->getOne($id)->toArray();
        }
        $form = FormActive::render($model::getAttributes(), $detail);
        $this->view->desc = '编辑主材分类';
        return $this->fetch('cateEdit', [
            'form'   => $form,
            'exists' => !empty($detail),
            'detail' => $detail
        ]);
    }

    /**
     * 删除分类
     * @return [type] [description]
     */
    public function cateDelete()
    {
        $id = $this->request->post('id');
        $main = Db::name('Materials')->where('cate_id', $id)->field('id')->find();
        $bind = Db::name('MaterialsCateBrand')->where('cate_id', $id)->field('id')->find();
        if ($main || $bind) {
            return error('分类已被占用，不可删除');
        }
        if (parent::model('MaterialsCate')->deleteOne($id)) {
            $res = success('删除成功');
        } else {
            $res = error('删除失败');
        }
        return $res;
    }

    /**
     * 分类绑定品牌
     * @return [type] [description]
     */
    public function bindBand()
    {
        $cateId = $this->request->param('id');
        $this->view->desc = '绑定品牌';
        return $this->fetch('bindBand');
    }

    public function brand()
    {
        $this->view->desc = '主材品牌';
        return $this->fetch();
    }
}