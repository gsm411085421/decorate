<?php
namespace app\index\controller;
use think\Cookie;

class Index extends Base
{
    public function index()
    {
        $brand = parent::model('MaterialsBrand')
            ->allDataWithSort('sorted ASC', ['is_on_home'=>1]);
        return $this->fetch('', [
            'brand' => $brand,
        ]);
    }
}
