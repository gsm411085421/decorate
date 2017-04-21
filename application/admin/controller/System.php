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
    public function usIntroduce()
    {   
        $this->view->desc = '网站介绍';
        $systemConfig = new SystemConfig();
        $data = $systemConfig->data();
        return $this->fetch('',['data'=>$data]);
    }

    /**
     * 网站信息
     * @return [type] [description]
     */
    public function usInfo()
    {
        $this->view->desc = '网站信息';
        $systemConfig = new SystemConfig();
        $data = $systemConfig->data();
        return $this->fetch('',['data'=>$data]);
    }
    
    /**
     * 更新系统配置
     * @return [type] [description]
     */
    public function update()
    {
        if($this->request->isPost()){
            $input = $this->request->post();
            foreach ($input as $key => $value) {
                $data = html_entity_decode($value);
                $input[$key]=$data;
            }
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