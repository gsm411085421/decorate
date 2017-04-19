<?php
/**
 * 辅材
 */
namespace app\admin\controller;
use fengniao\render\FormActive;

class Auxiliary extends Base
{

    protected $header = '辅材管理';

    public function index ()
    {
        $data = parent::model('Auxiliary')->getPaginate();

        $this->view->desc = '辅材列表';
        return $this->fetch('', ['data'=>$data]);
    }

    /**
     * 编辑
     * @return [type] [description]
     */
    public function edit ()
    {
        $model = parent::model('Auxiliary');
        $request = $this->request;

        if ($request->isPost()) {
            return $model->editAuxiliary($request->post());
        }

        $detail = [];
        if ($request->has('id') && $id = $request->param('id')) {
            $detail    = $model->getOne($id);
        }

        $form = FormActive::render($model::setAttributes(), $detail);

        $this->view->desc = '编辑辅材';
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
    public function auxiliaryDelete()
    {
        return parent::model('Auxiliary')->deleteOne($this->request->post('id'));
    }

    /**
     * 设置显示状态
     * @return [type] [description]
     */
    public function auxiliaryStatus()
    {
        $post = $this->request->post();
        return parent::model('Auxiliary')->setStatus($post['value'], ['id'=>$post['id']]);
    }
}