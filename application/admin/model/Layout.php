<?php
/**
 * 户型
 */

namespace app\admin\model;

class Layout extends Base
{
    public static $capitalNum = ['〇', '一', '二', '三', '四', '五', '六', '七', '八', '九'];

    protected $rule = [
        'estate_id|楼盘' => 'require|number',
        'name|户型名称'  => 'require|max:63',
        'room|卧室'      => 'require|gt:0'
    ];

    protected $message = [
        'estate_id.require' => '楼盘 ID 参数出错',
        'room.gt'           => '卧室数量输入有误'
    ];

    public function edit(array $input = [])
    {
        $room    = isset($input['room']) ? $input['room'] : 1;
        $hall    = isset($input['hall']) ? $input['hall'] : 0;
        $kitchen = isset($input['kitchen']) ? $input['kitchen'] : 0;
        $toilet  = isset($input['toilet']) ? $input['toilet'] : 0;
        $balcony = isset($input['balcony']) ? $input['balcony'] : 0;

        if (isset($input['name']) && $input['name']) {
            $name = $input['name'];
        } else {
            $name = self::_parseName($room, $hall, $kitchen , $toilet , $balcony);
        }

        $input['name'] = $name;
        return parent::edit($input);
    }

    public function updateName($id, $name)
    {
        return $this->where('id', $id)->update(['name'=>$name]);
    }
    /**
     * 生成户型名称
     * @param  integer  $room    室
     * @param  integer  $hall    厅
     * @param  integer  $kitchen 厨
     * @param  integer  $toilet  卫
     * @param  integer  $balcony 阳台
     * @return string
     */
    private static function _parseName($room, $hall = 0, $kitchen = 0, $toilet = 0, $balcony = 0)
    {
        $capitalNum = self::$capitalNum;
        $name = $capitalNum[$room]. '室';
        if ($hall) {
            $name .= $capitalNum[$hall]. '厅';
        }
        if ($toilet) {
            $name .= $capitalNum[$toilet]. '卫';
        }
        if ($kitchen) {
            $name .= '，'. $capitalNum[$kitchen] .'厨房';
        }
        if ($balcony) {
            $name .= '，带阳台';
        }
        return $name;
    }
}