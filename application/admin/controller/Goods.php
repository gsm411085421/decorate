<?php
namespace app\admin\controller;

use think\Db;
use fengniao\render\FormActive;

class Goods extends Base
{
    protected $header = '商品管理';

    protected $table = 'Goods';

    public function index()
    {
        $goodsLists = parent::model()->selectAll($this->userGroup);
        $this->view->desc = '商品列表';
        return $this->fetch('', [
            'data' => $goodsLists
        ]);
    }

    //////////////
    // 商品编辑 //
    //////////////

    /**
     * 编辑商品
     */
    public function add()
    {
        $request = $this->request;
        if ($request->isAjax() && $request->has('action')) {
            $res = '';
            switch ($request->param('action')) {
                // 加载属性表单视图
                case 'attribute' : 
                    $modelId = $request->param('model');
                    $formRenderData = parent::model('GoodsModelAttributes')->getViewDataByModel($modelId);
                    $res = FormActive::render($formRenderData);
                    break;
            }
            return $res;
        }
        if ($request->isPost()) {
            return parent::model()->addGoods($this->userGroup, $request->post('', null, null));
        }
        $detail   = [];
        $attrForm = '';
        if ($request->isGet() && $request->has('id')) { // 编辑
            $id = $request->param('id');
            $detail = parent::model()->selectOne($id, $this->userGroup);

            // 输出到 js 中的轮播图
            $strImg = '';
            foreach ($detail['img'] as $v) {
                $strImg .= "'".$v['src']."',";
            }
            $detail['img_js'] = substr($strImg, 0, -1);

            $attrRenderData = parent::model('GoodsModelAttributes')->getViewDataByModel($detail['model_id']);
            $attrData = [];
            foreach ($detail['attr'] as $v) {
                $attrData['attr['.$v['attr_id'].']'] = $v['value'];
            }
            $attrForm = FormActive::render($attrRenderData, $attrData);

            // dump($detail->toArray());
        }

        $this->view->desc = '添加商品';
        return $this->fetch('', [
            'type'        => $request->param('type'), // 1-普通商品 2-秒杀商品
            'modelCates'  => Db::name('GoodsModel')->column('name', 'id'),
            'seckillTime' => parent::model('GoodsSeckillTime')->selectAll(), // 秒杀时段
            'exists'      => !empty($detail),
            'detail'      => $detail,
            'attrForm'    => $attrForm,
        ]);
    }

    /**
     * 上架下架
     */
    public function setOnSale()
    {
        $goodsId = $this->request->post('id');
        $onSale  = $this->request->post('on_sale');
        $where = $this->userGroup ? ['id'=>$goodsId, 'warehouse_id'=>$this->userGroup] : ['id'=>$goodsId];
        return parent::model()->save(['is_on_sale'=>$onSale], $where);
    }

    public function setDelete()
    {
        $goodsId = $this->request->post('id');
        $where = $this->userGroup ? ['id'=>$goodsId, 'warehouse_id'=>$this->userGroup] : ['id'=>$goodsId];
        return parent::model()->save(['is_delete'=>$this->request->time()], $where);
    }


    /////////////////////
    // 商品分类管理 // // 
    /////////////// // //

    /**
     * 商品分类管理
     * @return [type] [description]
     */
    public function category()
    {
        $this->view->desc = '商品类别';
        return $this->fetch();
    }

    /**
     * 编辑商品类别
     * @return [type] [description]
     */
    public function categoryEdit()
    {
        $this->view->desc = '编辑商品类别';
        return $this->fetch();
    }

    //////////////////
    // 商品模型管理 //
    ////////////////// 

    /**
     * 
     商品模型管理
     * @return [type] [description]
     */
    public function modelIndex()
    {
        $this->view->desc = '商品模型';
        return $this->fetch('model', ['data'=>parent::model('GoodsModel')->getPaginate()]);
    }

    /**
     * 编辑商品模型
     * @return [type] [description]
     */
    public function modelEdit()
    {   
        $request = $this->request;
        if ($request->isPost()) {
            return parent::model('GoodsModel')->edit($request->post());
        }
        $this->view->desc = '编辑商品模型';
        return $this->fetch('modelEdit');
    }

    /**
     * 删除商品模型
     * @return [type] [description]
     */
    public function modelDelete()
    {
        $id = $this->request->post('id');
        $exists = Db::name('GoodsModelAttributes')->where('goods_model_id', $id)->field('id')->find();
        if ($exists) {
            return error('模型被占用，不能删除');
        }
        parent::model('GoodsModel')->deleteOne($id);
        return success();
    }

    //////////////////
    // 商品属性管理 //
    //////////////////

    /**
     * 商品属性管理
     * @return [type] [description]
     */
    public function attribute()
    {
        $model = parent::model('GoodsModelAttributes');
        $request = $this->request;

        $where  = [];
        $config = [];

        if ($request->has('model_id') && $modelId = $request->param('model_id')) {
            $where = $config['query'] = ['goods_model_id'=>$modelId];
        }

        if ($request->has('query')) {
            if ($modelId = $request->get('goods_model_id')) {
                $where = $config['query'] = ['goods_model_id'=>$modelId];
            }
        }

        $data = $model->getPaginate($where, true, null, $config);
        $goodsModelData = Db::name('GoodsModel')->column('name', 'id');

        $this->view->desc = '商品属性';
        return $this->fetch('', [
            'data' => $data,
            'goodsModelData' => $goodsModelData,
            'fieldFieldType' => $model::$fieldFieldType
        ]);
    }

    /**
     * 编辑商品属性
     * @return [type] [description]
     */
    public function attributeEdit()
    {
        $model   = parent::model('GoodsModelAttributes');
        $request = $this->request;

        if ($request->isPost()) {
            return $model->edit($request->post());
        }

        $detail = ['field_type'=>1]; // 录入方式初始值 
        $id     = 0;
        if ($request->isGet() && $request->has('id') && $id = $request->param('id')) {
            $detail = $model->getOne($id);
            if (strpos($detail['valid'], ',')) {
                $detail['valid'] = str_replace(',', "\n", $detail['valid']);
            }
        }

        $form = FormActive::render($model::getAttributes(), $detail);

        $this->view->desc = '编辑商品属性';
        return $this->fetch('attributeEdit', [
            'form' => $form,
            'id'   => $id,
        ]);
    }

    /**
     * 更新属性的排序值 
     * @return [type] [description]
     */
    public function attributeUpdateSorted()
    {
        $post = $this->request->post();
        return Db::name('GoodsModelAttributes')->where('id', $post['id'])->update(['sorted'=>$post['value']]);
    }

    /**
     * 删除属性
     * @return [type] [description]
     */
    public function attributeDelete()
    {
        $id = $this->request->post('id');
        $exists = Db::name('GoodsAttributes')->where('attr_id', $id)->find();
        if ($exists) {
            return error('当前属性已被占用，不可删除');
        }
        parent::model('GoodsAttributes')->deleteOne($id);
        return success();
    }

    //////////////////
    // 秒杀时段设置 //
    //////////////////

    public function seckillTime()
    {
        $this->view->desc = '秒杀时段设置';
        $data = parent::model('GoodsSeckillTime')->selectAll();
        return $this->fetch('seckillTime', [
            'data' => $data
        ]);
    }

    public function seckillTimeEdit()
    {
        return parent::model('GoodsSeckillTime')->edit($this->request->post());
    }

    public function seckillTimeDelete()
    {
        return parent::model('GoodsSeckillTime')->deleteItem($this->request->post('id'));
    }
}