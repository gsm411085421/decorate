<?php
/**
 * 商品模型 属性配置
 */

namespace app\admin\model;

use think\Db;

class GoodsModelAttributes extends Base
{
    public static $fieldFieldType = [1 => '文本输入', 2 => '选择'];

    protected $rule = [
        'goods_model_id|所属模型' => 'require',
        'attr_name|属性名称'      => 'require|max:63',
        'field_type|录入方式'     => 'require|in:1,2',
        'valid|可用值'            => 'max:255',
        'sorted|排序值'           => 'between:0,65536', 
    ];

    protected function setValidAttr($value, $data)
    {
        if ($data['field_type'] == 1) {
            return '';
        } else {
            $search = '';
            if (strpos($value, "\r\n")) {
                $search = "\r\n";
            } elseif (strpos($value, "\r")) {
                $search = "\r";
            }
            return str_replace($search, ',', $value);
        }
    }

    public static function getAttributes()
    {
        $allModel = Db::name('GoodsModel')->column('name', 'id');
        return [
            'attr_name'      => ['label'=>'属性名称', 'type'=>'input', 'inputType'=>'text'],
            'goods_model_id' => ['label'=>'所属模型', 'type'=>'select', 'valid'=>$allModel],
            'field_type'     => ['label'=>'录入方式', 'type'=>'input', 'inputType'=>'radio', 'valid'=>self::$fieldFieldType],
            'valid'          => ['label'=>'可用值列表', 'type'=>'textarea', 'attr'=>['placeholder'=>'仅录入方式为&nbsp;[选择]&nbsp;时有效，每行输入一个可选值']]
        ];
    }

    /**
     * 通过模型 id 查询视图渲染的数据源
     * @param  int $modelId Field : goods_model_id
     * @return array
     */
    public function getViewDataByModel($modelId)
    {
        $data = $this->where('goods_model_id', $modelId)
                    ->field('id,attr_name,field_type,valid')
                    ->order('sorted')
                    ->select();

        $res = [];
        $name = ''; $type = ''; $item = []; $valid = [];

        foreach ($data as $v) {
            $name = 'attr_'.$v['id'];
            $name = 'attr['.$v['id'].']';

            $item = ['label'=>$v['attr_name']];
            if ($v['field_type'] == 1) {
                $item['type']      = 'input';
                $item['inputType'] = 'text';
            } else {
                $valid = explode(',', $v['valid']);
                $item['type']  = 'select';
                $item['valid'] = array_combine($valid, $valid);
            }

            $res[$name] = $item;
        }
        return $res;
    }
}