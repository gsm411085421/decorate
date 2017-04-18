<?php
/**
 * 主材
 */

namespace app\admin\model;

use think\Db;
use app\admin\model\MaterialsDetail;
use think\Loader;

class Materials extends Base
{
    protected $rule = [
        'title|标题' => 'require|max:127',
        'price|单价' => 'require|number',
        'unit|单位'  => 'require|max:10',
        'cover|封面图' => 'require|max:63',
    ];

    protected $auto = ['update_at'];
    protected $insert = ['create_at'];

    public function setUpdateAtAttr($value)
    {
        return date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
    }

    public function setCreateAtAttr($value)
    {
        return date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
    }

    public function detail()
    {
        return $this->hasMany('MaterialsDetail', 'm_id', 'id')->field(true);
    }

    public static function getAttributes($cateId = 0, $brandId = 0)
    {
        $cateData = Db::name('MaterialsCate')->column('cate_name', 'id');
        array_unshift($cateData, '请选择');

        $brandData = $seriesData = [0=>'请选择'];
        if ($cateId) {
            $brandTemp = Loader::action('Api/getBrand', ['cateId'=>$cateId]);
            foreach ($brandTemp as $v) {
                $brandData[$v['id']] = $v['name'];
            }
            if ($brandId) {
                $seriesTemp = Loader::action('Api/getSeries', ['brandId'=>$brandId]);
                foreach ($seriesTemp as $v) {
                    $seriesData[$v['id']] = $v['name'];
                }
            }
        }
        
        return [
            'cate_id'   => ['label'=>'选择分类', 'type'=>'select', 'valid'=>$cateData],
            'brand_id'  => ['label'=>'选择品牌', 'type'=>'select', 'valid'=>$brandData],
            'series_id' => ['label'=>'选择系列', 'type'=>'select', 'valid'=>$seriesData],
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

    public function editMaterials(array $input)
    {
        $this->startTrans();
        try {
            $save = parent::edit($input);
            if ($save['code']) {
                $mId = $save['data']['id'];
                $saveDetail = (new MaterialsDetail)->addItems($mId, $input['detail']);
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