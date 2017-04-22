<?php
/**
 * 材料
 */

namespace app\index\controller;
use think\Db;

class Material extends Base
{
    public function index ()
    {
        $param = $this->request->param();
        //主材数据
        $data['data'] = parent::model('Materials')->getAllMaterials($param);
        //品牌
        $data['brand'] = parent::model('MaterialsBrand')->allDataWithSort('sorted ASC');
        //类别
        $data['cate'] = parent::model('MaterialsCate')->allDataWithSort('sorted ASC', ['status'=>1]);
        return $this->fetch('', [
            'data'  => $data,
            'param' => $param,
        ]);
    }

    /**
     * 主材详细数据
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function getDetail ($id)
    {
        $data['main'] = Db::name('Materials')->field('id,title,price')
            ->where(['id'=>$id,'status'=>1])->find();
        $data['detail'] = parent::model('MaterialsDetail')->getAllWithSort(['m_id'=>$id]);
        return $data;
    }
}