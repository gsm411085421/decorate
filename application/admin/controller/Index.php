<?php
namespace app\admin\controller;
use think\Db;

class Index extends Base
{

    protected $header = '首页';

    public function index()
    {
        $data['admin'] = session('uinfo.user');
        $data['sys']   = [
            'sysType'    => php_uname(),
            'version'    => php_uname('r'),
            'ip'         => $_SERVER['SERVER_NAME'],
            'phpVersion' => PHP_VERSION,
            'clickNum'   => Db::name('SiteInfo')->where('id', 1)->value('click_num'),
        ];
        $this->view->desc = '网站信息';
        return $this->fetch('', ['data'=>$data]);
    }

}
