<?php
namespace app\index\controller;
use think\Cookie;
use think\Loader;
use think\Db;

class Index extends Base
{
    public function index()


    {   

        $brand = parent::model('MaterialsBrand')
            ->allDataWithSort('sorted ASC', ['is_on_home'=>1]);
        $data = Loader::model('ConfigImg')->getAll();
        Db::name('SiteInfo')->where('id', 1)->setInc('click_num');
        return $this->fetch('', [
            'brand'     => $brand,
            'configImg' => $data,
        ]);

    }
}
