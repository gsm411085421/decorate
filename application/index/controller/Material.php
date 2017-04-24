<?php
/**
 * 材料
 */

namespace app\index\controller;
use think\Db;
use think\Cookie;

class Material extends Base
{

    use \traits\controller\Jump;

    public function index ()
    {
        $param = $this->request->param();
        if (isset($param['init_choose']) && $param['init_choose']) {
            Cookie::delete('material');
        }
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

    /** 
     * 材料筛选
     * @return [type] [description]
     */
    public function materialQuery ()
    {
        $param = $this->request->param();
        $materialBrandModel = parent::model('MaterialsBrand');
        //主材数据
        $data['data'] = parent::model('Materials')->getAllMaterials($param);
        if (isset($param['cate_id']) && $param['cate_id']) {
            $brandId = Db::name('MaterialsCateBrand')->where('cate_id', $param['cate_id'])->column('brand_id');
            //品牌
            $data['brand'] = $materialBrandModel->allDataWithSort('sorted ASC', ['id'=>['in', $brandId]]);
        } else {
            $data['brand'] = $materialBrandModel->allDataWithSort('sorted ASC');
        }
        //根据品牌查出系列
        if (isset($param['brand_id']) && $param['brand_id']) {
            $data['series'] = parent::model('MaterialsSeries')->allDataWithSort('sorted ASC', ['brand_id'=>$param['brand_id']]);
        }
        return $data;
    }

    /**
     * 将选择的主材存入cookie
     * @param [type] $id  [description]
     * @param [type] $num [description]
     */
    public function setMaterial ($id, $num, $area_id, $layout_id, $estate_id)
    {
        //查出选择的材料数据
        // $materialData = parent::model('Materials')->getOne($id);
        if (Cookie::has('material')) {
            $cookieData = Cookie::get('material');
            //合并数据
            if (isset($cookieData['area_'.$area_id])) {
                array_push($cookieData['area_'.$area_id], ['id'=>$id, 'num'=>$num]);
            } else {
                $cookieData['area_'.$area_id][] = ['id'=>$id, 'num'=>$num];
            }
            Cookie::set('material', $cookieData);
        } else {
            Cookie::set('material', ['area_'.$area_id => [['id'=>$id, 'num'=>$num]]]);
        }
        $this->redirect('Evaluation/index', [
            'estate_id' => $estate_id,
            'layout_id' => $layout_id,
        ]);
    }

}