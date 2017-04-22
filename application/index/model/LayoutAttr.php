<?php
namespace app\index\model;

class LayoutAttr extends Base
{
    /**
     * 获取面积
     * @param  [type] $layoutId [description]
     * @return [type]           [description]
     */
    public function getArea ($layoutId)
    {
        $data =  $this->field(true)
            ->where('layout_id', $layoutId)
            ->select();

        $count['wall_area'] = $count['floor_area'] = $count['perimeter'] = $count['top_area'] = 0;
        foreach ($data as $v) {
            $count['wall_area']  += $v['wall_area'];
            $count['floor_area'] += $v['floor_area'];
            $count['perimeter']  += $v['perimeter'];
            $count['top_area']   += $v['top_area'];
        }
        $count['total_area'] = $count['wall_area'] + $count['floor_area'] + $count['top_area'];
        return $count;
    }
}