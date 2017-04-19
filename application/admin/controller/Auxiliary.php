<?php
/**
 * 辅材
 */
namespace app\admin\controller;

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
            return $model->editMaterials($request->post());
        }

        $detail = [];
        if ($request->has('id') && $id = $request->param('id')) {
            $detail    = $model->getOne($id);
        }

        $form = FormActive::render($model::getAttributes($cateId, $brandId), $detail);

        $this->view->desc = '编辑辅材';
        return $this->fetch('', [
            'form'   => $form,
            'detail' => $detail,
            'exists' => !empty($detail)
        ]);
    }
}