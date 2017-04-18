<?php
namespace app\admin\controller;

use fengniao\render\FormActive;
use think\Db;

class Materials extends Base
{
    protected $header = '主材管理';

    public function index()
    {
        $data = parent::model('Materials')->getPaginate();

        $cate   = Db::name('MaterialsCate')->column('cate_name', 'id');
        $brand  = Db::name('MaterialsBrand')->column('name', 'id');
        $series = Db::name('MaterialsSeries')->column('name', 'id');

        $this->view->desc = '主材列表';
        return $this->fetch('', [
            'data'   => $data,
            'cate'   => $cate,
            'brand'  => $brand,
            'series' => $series,
        ]);
    }

    public function edit()
    {
        $model = parent::model('Materials');
        $request = $this->request;

        if ($request->isPost()) {
            return $model->editMaterials($request->post());
        }

        $detail = [];
        $cateId = $brandId = 0;
        if ($request->has('id') && $id = $request->param('id')) {
            $detail    = $model->getOne($id);
            // $arrDetail = $detail->toArray();
            $cateId    = $detail['cate_id'];
            $brandId   = $detail['brand_id'];
        }

        $form = FormActive::render($model::getAttributes($cateId, $brandId), $detail);

        $this->view->desc = '编辑主材';
        return $this->fetch('', [
            'form'   => $form,
            'detail' => $detail,
            'exists' => !empty($detail)
        ]);
    }

    /**
     * 删除主材
     * @return [type] [description]
     */
    public function materailsDelete()
    {
        return parent::model('Materials')->deleteOne($this->request->post('id'));
    }

    /**
     * 设置显示状态
     * @return [type] [description]
     */
    public function materailsStatus()
    {
        $post = $this->request->post();
        return parent::model('Materials')->setStatus($post['value'], ['id'=>$post['id']]);
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
     * 分类品牌列表
     * @return [type] [description]
     */
    public function cateBrandList()
    {
        $cateId = $this->request->param('cate_id');

        $data   = parent::model('MaterialsCateBrand')->getByCate($cateId);
        $this->view->desc = '分类品牌列表';
        return $this->fetch('cateBrandList', [
            'cateId' => $cateId,
            'data'   => $data
        ]);
    }

    /**
     * 编辑品牌
     */
    public function addBrand()
    {
        $cateId = 0;
        $request = $this->request;
        if ($request->isGet() && $request->has('cate_id') && $request->param('cate_id')) {
            $cateId = $request->param('cate_id');
        }

        if ($request->isPost()) {
            $data = $request->post();
            return parent::model('MaterialsBrand')->editBrand($data);
        }

        $detail = [];
        if ($request->isGet() && $request->has('id') && $id = $request->param('id')) {
            $detail = parent::model('MaterialsBrand')->getOne($id);
        }

        $this->view->desc = '添加品牌';
        return $this->fetch('addBrand', [
            'cateId' => $cateId,
            'detail' => $detail,
            'exists' => !empty($detail)
        ]);
    }

    /**
     * 品牌列表
     * @return [type] [description]
     */
    public function brand()
    {
        $data = parent::model('MaterialsBrand')->getPaginate();
        $this->view->desc = '主材品牌';
        return $this->fetch('', [
            'data' => $data
        ]);
    }

    /**
     * 删除品牌
     * @return [type] [description]
     */
    public function brandDelete()
    {
        $id = $this->request->post('id');
        $series = parent::model('MaterialsSeries')->where('brand_id', $id)->field('id')->find();
        $materails = parent::model('Materials')->where('brand_id', $id)->field('id')->find();
        if ($series || $materails) {
            $res = error('该品牌已被占用，不能删除');
        } else {
            if (parent::model('MaterialsBrand')->deleteOne($id)) {
                parent::model('MaterialsCateBrand')->where('brand_id', $id)->delete();
                $res = success('删除成功');
            } else {
                $res = error('删除失败了~');
            }
        }
        return $res;
    }

    /**
     * 系列管理
     * @return [type] [description]
     */
    public function series()
    {
        $brandId = $this->request->param('brand_id');

        $data = parent::model('MaterialsSeries')->getPaginate(['brand_id'=>$brandId]);

        $this->view->desc = '主材品牌系列';
        return $this->fetch('', [
            'brandId' => $brandId,
            'data'    => $data
        ]);
    }

    /**
     * 编辑系列
     * @return [type] [description]
     */
    public function seriesEdit()
    {
        $brandId = $this->request->param('brand_id');

        $model = parent::model('MaterialsSeries');
        $detail = [];

        if ($this->request->has('id') && $id = $this->request->param('id')) {
            $detail = $model->getOne($id);
        }

        if ($this->request->isPost()) {
            return $model->edit($this->request->post());
        }

        $form = FormActive::render($model::getAttributes(), $detail);

        $brandInfo = parent::model('MaterialsBrand')->getOne($brandId);

        $this->view->desc = '主材品牌系列编辑';
        return $this->fetch('seriesEdit', [
            'form'      => $form,
            'brandInfo' => $brandInfo,
            'detail'    => $detail
        ]);
    }

    /**
     * 删除系列
     * @return [type] [description]
     */
    public function seriesDelete()
    {
        $seriesId = $this->request->post('id');
        $materails = parent::model('Materials')->where('series_id', $seriesId)->field('id')->find();
        if ($materails) {
            $res = error('该系列已被占用，不可删除');
        } else {
            if (parent::model('MaterialsSeries')->deleteOne($seriesId)) {
                $res = success('删除成功');
            } else {
                $res = error('删除失败了~');
            }
        }
        return $res;
    }
}