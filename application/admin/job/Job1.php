<?php
namespace app\admin\job;

use think\queue\Job;

class Job1
{
    public function fire(Job $obj, $data)
    {
        $file = ROOT_PATH.'cache.data';
        // file_put_contents($file, 'msg', FILE_APPEND);
        $data['time'] = date('Y-m-d H:i:s');
        // \think\Cache::set('hello', 'job');
        file_put_contents($file, json_encode($data)."\n", FILE_APPEND);
        $obj->delete();
    }

    public function task1(Obj $obj, $data)
    {
        $file = ROOT_PATH.'cache.data';
        // $data['time'] = date('Y-m-d H:i:s');
        file_put_contents($file, 'msg', FILE_APPEND);
    }

    public function failed($data)
    {
        $file = ROOT_PATH.'cache.data';
        $data['time'] = date('Y-m-d H:i:s');
        $data['error'] = 'error';
        file_put_contents($file, json_encode($data), FILE_APPEND);
    }
}