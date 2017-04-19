<?php
/**
 * 主材品牌
 */

namespace app\admin\model;

use think\Db;

class MaterialsBrand extends Base
{
    protected $rule = [
        'name|品牌名称' => 'require|max:63|unique:MaterialsBrand',
        'logo'          => 'require|max:63',
        'sorted|排序值' => 'between:0,255',
        'is_on_home|是否显示在首页' => 'in:0,1'
    ];

    public function editBrand(array $post)
    {
        $cateId = false;
        if (isset($post['cate_id']) && $post['cate_id']) {
            $cateId = $post['cate_id'];
        }

        if ($cateId) {
            $this->startTrans();
            try {
                $save = parent::edit($post);
                if ($save['code']) {
                    if (!isset($post['id']) || !$post['id']) { // 新增操作
                        Db::name('MaterialsCateBrand')->insert(['cate_id'=>$cateId, 'brand_id'=>$save['data']['id']]);
                    }
                }
                $this->commit();
                return $save;
            } catch (\Exception $e) {
                $this->rollback();
                return error($e->getMessage());
            }
        } else {
            return parent::edit($post);
        }
    }
}