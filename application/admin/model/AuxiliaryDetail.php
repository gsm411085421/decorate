<?php
/**
 * 主材详情
 */

namespace app\admin\model;

class AuxiliaryDetail extends Base
{
    public function addItems($auxiliaryId, array $input)
    {
        if (empty($input) || !isset($input['title'])) {
            return false;
        }
        $length = count($input['title']);
        if ($length < 1) {
            return false;
        }
        $this->where('a_id', $auxiliaryId)->delete();
        $saveData = [];
        for ($i = 0; $i < $length; $i ++) {
            $saveData[] = [
                'a_id'    => $auxiliaryId,
                'title'   => $input['title'][$i],
                'summary' => $input['summary'][$i],
                'cover'   => $input['cover'][$i],
                'sorted'  => $input['sorted'][$i] ? : 50,
            ];
        }
        return $this->saveAll($saveData);
    }
}