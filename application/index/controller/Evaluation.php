<?php
/**
 * 估价
 */

namespace app\index\controller;
use think\Db;
use think\Cookie;

class Evaluation extends Base
{

    use \traits\controller\Jump;

    public function index ()
    {
        // Cookie::delete('auxiliary');
        $param = $this->request->param();
        //辅材
        $auxiliaryId = Cookie::has('auxiliary') ? Cookie::get('auxiliary') : 0;
        $data['auxiliary'] = parent::model('Auxiliary')->getOne($auxiliaryId)->toArray();
        //主材
        $allMaterial = to_array(parent::model('Materials')->getAll());
        $materialId  = Cookie::has('material') ? Cookie::get('material') : [];
        $data['estate'] = Db::name('Estate')->where('status', 1)->order('sorted ASC')->select();//楼盘
        $data['material'] = [];
        foreach ($materialId as $k=>$v) {
            foreach ($v as $sv) {
                foreach ($allMaterial as $ssv) {
                    if ($ssv['id'] == $sv['id']){
                        $ssv['num'] = $sv['num'];
                        $data['material'][$k][] = $ssv;
                    }
                }
            }
        }
        if (isset($param['layout_id']) && $param['layout_id']){
            $data['layoutArea'] = $this->calcArea($param['layout_id']);
        }
        if (isset($param['estate_id']) && $param['estate_id']){
            $data['layoutData'] = $this->getLayout($param['estate_id']);
        }
        $data['usageArea'] = parent::model('UsageArea')->allDataWithSort('sorted ASC');
        //清单
        $list = [];
        if (isset($param['confirm']) && $param['confirm']) {
            if (isset($param['estate_id']) && $param['estate_id']) {
                $list['estate'] = parent::model('Estate')->getOne($param['estate_id']);
            }
            if (isset($param['layout_id']) && $param['layout_id']) {
                $list['layout'] = parent::model('Layout')->getOne($param['layout_id']);
                $list['layoutAttr'] = parent::model('LayoutAttr')->getAll(['layout_id'=>$param['layout_id']]);
            }
        }
        return $this->fetch('', [
            'data'  => $data,
            'param' => $param,
            'list'  => $list,
        ]);
    }

    /**
     * 辅材
     */
    public function accessories ($isCal = 0)
    {
        $param = $this->request->param();
        $data = Db::name('Auxiliary')->field(true)->where('status', 1)->select();
        return $this->fetch('', ['data'=>$data, 'isCal'=>$isCal, 'param'=>$param]);
    }

    /**
     * 辅材详细页面
     * @param  [type] $auxiliaryId 辅材id
     * @return [type]              [description]
     */
    public function accessoriesDetail ($id)
    {
        $data['main'] = Db::name('Auxiliary')->field('id,title,price')
            ->where(['id'=>$id,'status'=>1])->find();
        $data['detail'] = parent::model('AuxiliaryDetail')->getAllWithSort(['a_id'=>$id]);
        return $data;
    }

    /**
     * 确认选择
     * @return [type] [description]
     */
    public function inventory ()
    {
        return $this->fetch();
    }

    /**
     * 根据楼盘id获取户型
     * @param  [type] $estateId [description]
     * @return [type]           [description]
     */
    public function getLayout ($estateId)
    {
        return Db::name('Layout')->where('estate_id', $estateId)
            ->order('sorted ASC')->select();
    }

    /**
     * 计算面积
     * @return [type] [description]
     */
    public function calcArea ($layoutId)
    {
        if ($layoutId) {
            return parent::model('LayoutAttr')->getArea($layoutId);
        }
    }

    /**
     * 选择辅材
     * @param [type] $auxiliaryId [description]
     */
    public function setAuxiliary ($id)
    {
        $param = $this->request->param();
        Cookie::set('auxiliary', $id);
        $this->redirect('Evaluation/index',[
            'estate_id' => $param['estate_id'], 
            'layout_id' => $param['layout_id'],
        ]);
    }

}