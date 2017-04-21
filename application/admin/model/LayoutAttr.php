<?php
namespace app\admin\model;

class LayoutAttr extends Base
{

    protected $rule = [
        'name|户型属性名称'   => 'require',
        'wall_area|墙面面积'  => 'require|number',
        'floor_area|地面面积' => 'require|number',
        'perimeter|周长'      => 'require|number',
        'top_area|顶面面积'   => 'require|number',
        'sorted|排序'         => 'between:0,255|number',
    ];

    public function getDataByType ($layoutId)
    {
        $arr = [];
        $layoutAttrData = $this->field(true)->where('layout_id', $layoutId)->select();
        foreach ($layoutAttrData as $v) {
            $arr[$v['type']][] = $v->toArray();
        }
        return $arr;
    }

    /**
     * 保存
     * @return [type] [description]
     */
    public function layoutAttrEdit ($data)
    {
        $info = [];
        $this->where('layout_id', $data['layout_id'][0][0])->delete();
        foreach ($data['name'] as $type=>$v) {
            foreach ($v as $k=>$sv) {
                $info[] = [
                    'name'       => $sv,
                    'layout_id'  => $data['layout_id'][0][$k],
                    'type'       => $type,
                    'wall_area'  => $data['wall_area'][$type][$k],
                    'floor_area' => $data['floor_area'][$type][$k],
                    'perimeter'  => $data['perimeter'][$type][$k],
                    'top_area'   => $data['top_area'][$type][$k],
                ];
            }
        }
        $res = $this->validate($this->rule)->isUpdate(false)->saveAll($info);
        if($res !== false) {
            return ['code'=>1, 'msg'=>'保存成功'];
        } else {
            return ['code'=>0, 'msg'=>$this->getError()];
        }
    }

}