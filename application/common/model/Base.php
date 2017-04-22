<?php
namespace app\common\model;

use think\Model;
use think\Request;
use think\Validate;
/**
 * @method array post() post 数据
 * @method array get()  get 数据
 * @method Model getOne($id) 查询一条
 * @method Collection getAll(array $where=[]) 查询全部
 * @method integer getCount(array $where=[]) 统计总数
 * @method array edit(array $input) 编辑数据 
 * @method array addOne(array $input) 添加一条
 * @method array updateOne(array $input) 更新一条
 * @method integer setStatus($value, $where) 修改 status 字段的值
 * @method integer deleteOne($id, array $extra=[]) 删除一条数据
 */
class Base extends Model
{
    protected $table = false;

    protected $pageSize = 20;

    // 时间字段取出后的默认时间格式
    protected $dateFormat = false;
    // 创建时间字段
    protected $createTime = 'create_at';
    // 更新时间字段
    protected $updateTime = 'update_at';
    /**
     * 数据表主键字段
     * @var string
     */
    protected $pk = 'id';

    /**
     * \think\Request 实例
     * @var Object
     */
    protected $request;

    /**
     * 验证规则
     * @var array
     */
    protected $rule;
    /**
     * 验证提示信息
     * @var array
     */
    protected $message = [];

    protected function initialize()
    {
        parent::initialize();
        
        $this->request = Request::instance();
    }
/**
 * post 请求中的数据
 * @return array
 */
    protected function requestPost($name = '')
    {
        return $this->request->post($name);
    }
/**
 * get 请求中的数据
 * @return array
 */
    protected function requestGet($name = '')
    {
        return $this->request->get($name);
    }
/**
 * 根据主键查询一条
 * @param  string $id 主键值
 * @param  mix    $feild 查询字段 
 * @return Model     数据库对象
 */
    public function getOne($id, $field = true)
    {
        return $this->field($field)->where($this->pk, $id)->find();
    }
/**
 * 全表查询
 * @param array $where 查询条件
 * @param mix   $feild 查询字段 
 * @return Collection
 */
    public function getAll(array $where = [], $field = true)
    {
        return $this->field($field)->where($where)->select();
    }
/**
 * count 查询
 * @param  array $where 查询条件
 * @return integer
 */
    public function getCount(array $where=[])
    {
        return $this->where($where)->count();
    }
/**
 * 编辑
 * @param  array  $input 表单数据
 * @return array        std
 */
    public function edit(array $input = [])
    {
        $input = $input ? : $this->requestPost();
        $check = 0;
        if ($this->rule) {
            $validate = Validate::make($this->rule, $this->message);
            $check = $validate->check($input);

            if (false === $check) {
                return ['code'=>0, 'msg'=>$validate->getError()];
            }
        }
        if ($check || ! $this->rule) {
            $isUpdate = isset($input[$this->pk])&&$input[$this->pk] ? true : false;
            $handle = $this->allowField(true)->isUpdate($isUpdate)->save($input);
            $res = $handle ? ['code'=>1, 'msg'=>'操作成功', 'data'=>['id'=>$this->id]] : ['code'=>0, 'msg'=>'操作失败'];
        }
        return $res;
    }
/**
 * 新增一条数据 
 * @param  array $input 表单数据 
 * @return array  std
 */
    public function addOne(array $input = [])
    {
        $input = $input ? : $this->requestPost();
        $handle = $this->allowField(true)->isUpdate(false)->save($input);
        if ($handle) {
            return ['code'=>1, 'msg'=>'添加成功', 'data'=>['id'=>$this->id]];
        }else{
            return ['code'=>0, 'msg'=>'添加失败'];
        }
    }
/**
 * 更新一条数据 
 * @param  array  $input 表单数据 
 * @return array        std
 */
    public function updateOne(array $input = [])
    {
        $input = $input ? : $this->requestPost();
        $handle = $this->allowField(true)->isUpdate(true)->save($input);
        if ($handle) {
            return ['code'=>1, 'msg'=>'修改成功', 'data'=>['id'=>$this->id]];
        }else{
            return ['code'=>0, 'msg'=>'修改失败'];
        }
    }
/**
 * 设置状态
 * @param integer $value 状态值
 * @param array  $where 条件
 * @return integer
 */
    public function setStatus($value, array $where)
    {
        return $this->save(['status'=>$value], $where);
    }
/**
 * 删除一条
 * @param  string $id    主键值
 * @param  array $extra 额外条件
 * @return integer        删除的条数
 */
    public function deleteOne($id, array $extra=[])
    {
        return $this->where($this->pk, $id)->where($extra)->delete();
    }
/**
 * 分页查询
 * @param  array   $where    条件
 * @param  boolean $field    字段
 * @param  int  $pageSize 分页大小 默认20
 * @return
 */
    public function getPaginate(array $where=[], $field=true, $pageSize=null, $config=[])
    {
        $pageSize = $pageSize ? : $this->pageSize;
        return $this->where($where)->field($field)->paginate($pageSize, false, $config);
    }
/**
 * limit 分页查询
 * @param  integer $page     页码
 * @param  array   $where
 * @param  boolean $field
 * @param  int  $pageSize
 * @return array
 */
    public function getListsByPage($page=1, $where=[], $field=true, $pageSize=null)
    {
        $pageSize = $pageSize ? : $this->pageSize;
        return $this->where($where)->field($field)->limit($pageSize)->page($page)->select();
    }

    /**
     * 所有数据
     * @param  stirng  $sortField 排序字段
     * @param  array   $where     条件
     * @param  boolean $field     字段
     * @return [type]             [description]
     */
    public function allDataWithSort ($sortField, $where = [], $field = true)
    {
        return $this->field($field)->where($where)->order($sortField)->select();
    }
}