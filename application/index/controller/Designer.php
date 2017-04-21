<<<<<<< HEAD
<?php  
=======
<?php
/**
 * 估价
 */

>>>>>>> master
namespace app\index\controller;

class Designer extends Base
{
<<<<<<< HEAD
    public function designer()
    {   
        $data = parent::model()->getAll();
        return $this->fetch('',['designer'=>$data]);
=======
    public function index ()
    {
        return $this->fetch();
>>>>>>> master
    }
}