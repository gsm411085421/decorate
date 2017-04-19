<?php
/**
 * 主材详情
 */

namespace app\admin\model;

class MaterialsDetail extends Base
{
    public function addItems($materialsId, array $input)
    {
        if (empty($input) || !isset($input['title'])) {
            return false;
        }
        $length = count($input['title']);
        if ($length < 1) {
            return false;
        }
        $this->where('m_id', $materialsId)->delete();
        $saveData = [];
        for ($i = 0; $i < $length; $i ++) {
            $saveData[] = [
                'm_id'    => $materialsId,
                'title'   => $input['title'][$i],
                'summary' => $input['summary'][$i],
                'cover'   => $input['cover'][$i],
                'sorted'  => $input['sorted'][$i] ? : 50,
            ];
        }
        return $this->saveAll($saveData);
    }
}