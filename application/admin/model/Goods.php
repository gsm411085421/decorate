<?php
/**
 * 商品
 */

namespace app\admin\model;

use think\Validate;
use app\admin\model\GoodsImg;
use app\admin\model\GoodsPrice;
use app\admin\model\GoodsSeckill;
use app\admin\model\GoodsAttributes;

class Goods extends Base
{
    protected $rule = [
        'warehouse_id'                   => 'require',
        'type|商品秒杀'                  => 'require|in:1,2',
        'cate_id|分类 id'                => 'require',
        'model_id|模型 id'               => 'require',
        'goods_name|商品名'              => 'require|max:255',
        'suggested_price|建议售价'       => 'gt:0',
        'seckill_price|秒杀价'           => 'gt:0',
        'summary|商品摘要'               => 'max:255',
        'promotion_information|促销信息' => 'max:255',
        'cover|封面图'                   => 'require|max:63',
    ];

    protected $message = [
        'warehouse_id.require' => '仓库 id 参数出错',
        'type.in'              => '商品秒杀参数出错',
    ];

    protected $auto   = ['update_at'];
    protected $insert = ['create_at'];

    protected function setCreateAtAttr()
    {
        return date('Y-m-d H:i:s', $this->request->time());
    }

    protected function setUpdateAtAttr()
    {
        return date('Y-m-d H:i:s', $this->request->time());
    }

    public function attr()
    {
        return $this->hasMany('GoodsAttributes', 'goods_id', 'id')->field('goods_id,attr_id,value');
    }

    public function img()
    {
        return $this->hasMany('GoodsImg', 'goods_id', 'id')->field('goods_id,src');
    }

    public function price()
    {
        return $this->hasMany('GoodsPrice', 'goods_id', 'id')->field('goods_id,spec_name,price,inventory');
    }

    public function seckill()
    {
        return $this->hasMany('GoodsSeckill', 'goods_id', 'id')->field(true);
    }


    public function selectAll($userGroupId, array $query = [])
    {
        $where = ['is_delete'=>0, 'warehouse_id'=>$userGroupId];
        return parent::getPaginate($where, true, null, []);
    }

    public function selectOne($id, $userGroupId)
    {
        $where = ['id'=>$id, 'warehouse_id'=>$userGroupId];
        return self::with('attr,img,price,seckill')->where($where)->field(true)->find();
    }




    /**
     * 添加商品
     * @param int   $userGroupId 商家 id
     * @param array $input [description]
     */
    public function addGoods($userGroupId, array $input)
    {        
        $input['store_count']  = array_sum($input['price']['store']); // 总库存
        $input['warehouse_id'] = $userGroupId; // 仓库 id

        // 数据验证
        $validate = Validate::make($this->rule, $this->message);
        if (!$validate->check($input)) {
            return error($validate->getError());
        }

        $this->startTrans();
        try {
            $isUpdate = isset($input['id'])&&$input['id'] ? true : false;
            $save = $this->allowField(true)->isUpdate($isUpdate)->save($input);
            if ($save === false) {
                abort(500, '商品基本信息保存失败');
            }
            // 商品价格
            (new GoodsPrice)->addItems($this->id, $input['price']['name'], $input['price']['price'], $input['price']['store']);
            // 商品图片
            (new GoodsImg)->addItems($this->id, $input['goods_img']);
            // 商品属性
            (new GoodsAttributes)->addItems($this->id, $input['attr']);
            if ($input['type'] == 2) { // 秒杀商品
                (new GoodsSeckill)->addItems($this->id, $input['seckill']['time'], $input['seckill']['date']);
            }
            $this->commit();
            $res = success('商品添加成功', ['id'=>$this->id]);
        } catch (\Exception $e) {
            $this->rollback();
            $res = error($e->getMessage());
        }
        return $res;
    }

    public function truncateTable()
    {
        $table = ['tp_goods', 'tp_goods_price', 'tp_goods_img', 'tp_goods_attributes', 'tp_goods_seckill'];
        foreach ($table as $v) {
            $this->execute('truncate table '.$v);
        }
    }

}