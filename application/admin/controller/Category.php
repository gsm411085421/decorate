<?php
namespace app\admin\controller;

class Category extends Base
{
    protected $header = '分类管理';

    protected $table  = 'Category';

    public function index()
    {   
        $model = parent::model();
        $data = to_array($model->getAll());
        $data = $model->buildWithIndentation($data);
        $this->view->desc = '商品分类';
        return $this->fetch('', [
            'data' => $data,
            'inputIcon' => $model->inputIcon
        ]);
    }

    /**
     * 编辑无限级分类
     */
    public function addInfinite()
    {   
        $request = $this->request;
        $model   = parent::model();
        if ($request->isPost()) {
            return $model->edit($request->post());
        }

        $detail = [];
        if ($request->has('id') && $id = $request->param('id')) {
            $detail = $model->getOne($id);
        }

        $categories = $model->buildWithIndentation();
        // dump($categories);
        $this->view->desc = '添加分类';
        return $this->fetch('addInfinite', [
            'exists'     => !empty($detail),
            'detail'     => $detail,
            'categories' => $categories,
            'inputIcon'  => $model->inputIcon
        ]);
    }

    /**
     * 删除分类
     * @return [type] [description]
     */
    public function delete()
    {
        $id = $this->request->post('id');
        // 子类判断
        $existsChild = parent::model()->where('pid', $id)->find();
        // 商品占用判断
        $existsGoods = false ;
        if ($existsChild || $existsGoods) { // 不可删除
            $res = error('当前分类被占用，不可删除');
        } else {
            if (parent::model()->deleteOne($id)) {
                $res = success('删除成功');
            } else {
                $res = error('发生错误，删除失败');
            }
        }
        return $res;
    }
}