<?php  
namespace app\admin\controller;

use app\common\api\SystemConfig;

class System extends Base
{   

    protected $header = '系统配置';

    /**
     * 网站介绍
     * @return [type] [description]
     */
    public function index()
    {   
        $this->view->desc = '网站介绍';
        $systemConfig = new SystemConfig();
        $data = $systemConfig->data();
        return $this->fetch('',['data'=>$data]);
    }

    public function update()
    {
        if($this->request->isPost()){
            $input = $this->request->post();
            $input['about_us'] = html_entity_decode($input['about_us']);
            $systemConfig = new SystemConfig();
            $data = $systemConfig->update($input);
            if($data){
                return ['code'=>1,'msg'=>'修改成功'];
            }else{
                return ['code'=>0,'msg'=>'修改失败'];  
            }
        }
    }



}