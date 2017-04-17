<?php
namespace app\admin\model;

class Article extends Base
{
    use \traits\model\SoftDelete;

    /*public function setTagsAttr($value)
    {
        return str_replace('，', ',', $value);
    }*/

/**
 * 软删除
 * @param  string $id 文章 ID
 * @return [type]     [description]
 */
    public function softDelete($id)
    {
        $this->save(['status'=>2], ['id'=>$id]);
        return self::destroy($id);
    }
/**
 * 软删除恢复
 * @param  string $id 文章 ID
 * @return
 */
    public function restoreFromTrash($id)
    {
        return $this->restore(['id'=>$id]);
    }

/**
 * 删除一条 真实删除
 * @param  string $id    主键值
 * @param  array $extra 额外条件
 * @return integer        删除的条数
 */
    public function deleteOne($id, array $extra=[])
    {
        return self::destroy($id, true);
    }
/**
 * 新增
 * @param int $uid
 * @param array  $input
 * @return std
 */
    public function addItem($uid, array $input)
    {
        $input['uid'] = $uid;
        if ($this->validate(true)->allowField(true)->save($input)) {
            $res = ['code'=>1, 'msg'=>'添加成功', 'data'=>['id'=>$this->id]];
        } else {
            $res = ['code'=>0, 'msg'=>$this->getError() ? : '添加失败'];
        }
        return $res;
    }
/**
 * 修改
 * @param  int $uid
 * @param  array  $input
 * @return std
 */
    public function editItem($uid, array $input)
    {
        $input['update_uid'] = $uid;
        $input['update_at']  = date('Y-m-d H:i:s');

        if ($this->validate(true)->allowField(true)->isUpdate(true)->save($input, ['id'=>$input['id']])) {
            $res = ['code'=>1, 'msg'=>'更新成功', 'data'=>['id'=>$input['id']]];
        } else {
            $res = ['code'=>0, 'msg'=>$this->getError() ? : '更新失败'];
        }
        return $res;
    }

    public function getOne($id, $field=true)
    {
        return self::withTrashed()->field($field)->find($id);
    }
/**
 * 分页查询
 * @param  int $pageSize 分页大小
 * @return Collection
 */
    public function getPage($pageSize = self::PAGE_SIZE)
    {
        return $this->field('content,delete_time', true)->order('id desc')->paginate($pageSize);
    }
/**
 * 回收站数据分页查询
 * @param  int $pageSize 分页大小
 * @return Collection
 */
    public function getPageOnlyTrash($pageSize = self::PAGE_SIZE)
    {
        return self::onlyTrashed()->field('content,delete_time', true)->order('id desc')->paginate($pageSize);
    }
}