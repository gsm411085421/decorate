<?php
/**
 * 无限级分类表
 */

namespace app\admin\model;

use think\Collection;

class Category extends Base
{
    public $inputIcon = true; // 是否需要图标

    protected $optionIndentation = 4; // option 中分类名缩进值

    protected $rule = [
        'cate_name|分类名' => 'require|max:63',
        'icon|分类图标'    => 'max:63',
        'sorted|排序值'    => 'between:0,127'
    ];

    /**
     * 查询基本字段 id, pid, cate_name
     * @return array
     */
    public function getBaseInfo()
    {
        $info = $this->field('id,pid,cate_name')->order('sorted')->select();
        return Collection::make($info)->toArray();
    }

    /**
     * 构建树
     * @param  array  &$data 数据
     * @param  integer $pid
     * @param  integer $level
     * @return array
     */
    public function buildWithIndentation(&$data = null, $pid = 0, $level = 1)
    {
        static $res;
        $data = is_null($data) ? $this->getBaseInfo() : $data;
        foreach ($data as $k => $v) {
            if ($v['pid'] == $pid) {
                $v['level'] = $level;
                $v['indentation'] = str_repeat('&nbsp;', $level * $this->optionIndentation);
                $res[] = $v;
                unset($data[$k]);
                $this->buildWithIndentation($data, $v['id'], $level + 1);
            }
        }
        return $res;
    }
}