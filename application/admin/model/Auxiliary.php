<?php
namespace app\admin\model;

class Auxiliary extends Base
{
    protected $auto = ['update_at'];

    public function setUpdateAtAttr($value)
    {
        return date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
    }

    public function detail()
    {
        return $this->hasMany('AuxiliaryDetail', 'a_id', 'id')->field(true);
    }

    public static function setAttributes ()
    {
        return [
            'title'     => ['label'=>'标题', 'type'=>'input', 'inputType'=>'text'],
            'summary'   => ['label'=>'摘要', 'type'=>'textarea'],
            'price'     => ['label'=>'单价', 'type'=>'input', 'inputType'=>'number'],
            'unit'      => ['label'=>'单位', 'type'=>'input', 'inputType'=>'text']
        ];
    }

    public function getOne($id, $field = true)
    {
        return self::with('detail')->field($field)->where('id', $id)->find();
    }

    public function editAuxiliary (array $input)
    {
        $this->startTrans();
        try {
            $save = parent::edit($input);
            if ($save['code']) {
                $aId = $save['data']['id'];
                $saveDetail = (new AuxiliaryDetail)->addItems($aId, $input['detail']);
                if ($saveDetail) {
                    $res = success('保存成功');
                } else {
                    $res = error('详情保存出错');
                }
            } else {
                $res = error($save['msg']);
            }
            $this->commit();
            return $res;
        } catch (\Exception $e) {
            $this->rollback();
            return error($e->getMessage());
        }
    }
}