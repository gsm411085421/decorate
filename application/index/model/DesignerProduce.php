<?php  
namespace app\index\model;

class DesignerProduce extends Base
{   
    /**
     * 关联作品图片表
     * @return [type] [description]
     */
    public function designerProduceImg()
    {
        return $this->hasMany('DesignerProduceImg','produce_id','id')->field('produce_id,img_url');
    }

    /**
     * 获取所有作品对应的图片
     * @param  [type] $desiger [description]
     * @return [type]          [description]
     */
    public function getProduce($desiger)
    {
        $info = self::with('designerProduceImg')
                ->where('designer_id', $desiger)
                ->where('status', 1)
                ->field(true)
                ->order('sort')
                ->select();
        $data = to_array($info);
        $res  = array_map(function($v){
            $item = [
                'id'        => $v['id'],
                'img'       => $v['img_url'],
                'name'      => $v['name'],
                'introduce' => $v['introduce'],
                'projects'  => []
                ];
            foreach ($v['designer_produce_img'] as $p) {
                $item['projects'][] = $p['img_url'];
            }
            return $item;
        }, $data);
        return $res;
    }
}