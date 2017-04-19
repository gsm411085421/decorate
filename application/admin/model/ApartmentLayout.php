<?php
namespace app\admin\model;

class ApartmentLayout extends Base
{
    /**
     * 更新字段值
     * @return [type] [description]
     */
    public function updateField ()
    {
        $data = parent::requestPost();
        return $this->where('id', $data['id'])->setField($data['field'], $data['value']);
    }
}