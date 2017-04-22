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
        $options = $this->request->param();

        //辅材
        $data['auxiliary'] = Cookie::has('auxiliary') ? Cookie::get('auxiliary') : [];
        //主材
        
        $data['estate'] = Db::name('Estate')->where('status', 1)->order('sorted ASC')->select();//楼盘
        return $this->fetch('', [
            'data' => $data,
        ]);
    }

    /**
     * 辅材
     */
    public function accessories ($isCal = 0)
    {
        $data = Db::name('Auxiliary')->field(true)->where('status', 1)->select();
        return $this->fetch('', ['data'=>$data, 'isCal'=>$isCal]);
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
     * 主材
     */
    public function material ()
    {
        return $this->fetch();
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
    public function setAuxiliary ($auxiliaryId)
    {
        $auxiliary = Db::name('Auxiliary')->field('title')->where('id', $auxiliaryId)->find();
        if ($auxiliary) {
            if (Cookie::has('auxiliary')) {
                Cookie::delete('auxiliary');
            };
            Cookie::set('auxiliary', $auxiliary);
        }
        $this->redirect('Evaluation/index');
    }
}