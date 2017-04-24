<?php
namespace app\index\controller;
use think\Cookie;

use think\Loader;

class Index extends Base
{
    public function index()

    {   
        $data = Loader::model('ConfigImg')->getAll();
        $brand = parent::model('MaterialsBrand')->allDataWithSort('sorted ASC', ['is_on_home'=>1]);
        return $this->fetch('', [
            'brand' => $brand,
            'configImg'=>$data
        ]);

    }
}
