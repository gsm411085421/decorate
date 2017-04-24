<?php
namespace app\index\controller;

use think\Loader;
use app\common\api\SystemConfig;

class Designer extends Base
{

    public function index()
    {   
        $data = parent::model()->getAll();
        $systemConfig = new SystemConfig();
        $systemData = $systemConfig->data();
        return $this->fetch('',[
            'designer'=>$data,
            'designerImg'=>$systemData['designer_img'],
            'designerWords'=>$systemData['designer']
            ]);
    }

    public function produce($id)
    {  
        $data = parent::model('DesignerProduce')->getProduce($id);
        return $this->fetch('', ['data'=>$data]);
    }


}