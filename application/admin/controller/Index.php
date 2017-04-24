<?php
namespace app\admin\controller;
use think\Db;

class Index extends Base
{
    public function index()
    {
        $data['admin'] = session('admin_user.name');
        $data['sys']   = [
            'sysType'    => php_uname(),
            'version'    => php_uname('r'),
            'ip'         => $_SERVER['SERVER_NAME'],
            'phpVersion' => PHP_VERSION,
            'clickNum'   => Db::name('SiteInfo')->value('click_num'),
        ];
        return $this->fetch('', ['data'=>$data]);
    }

}
