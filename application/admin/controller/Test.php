<?php
namespace app\admin\controller;

use fengniao\render\FormActive;

class Test extends Base
{
    public function index()
    {
        $options = [
            'name'     =>['type'=>'input', 'inputType'=>'text', 'label'=>'姓名', 'class'=>'input-sm'],
            'password' =>['type'=>'input', 'inputType'=>'password', 'label'=>'密码', 'attr'=>['disabled'=>'', 'data-id'=>1]],
            'gender'   =>['type'=>'input', 'inputType'=>'radio', 'label'=>'性别', 'valid'=>['男'=>1, '女'=>2]],
            'hoby'     =>['type'=>'input', 'inputType'=>'checkbox', 'label'=>'爱好', 'valid'=>['音乐'=>1, '看书'=>2, '跑步'=>'3']],
            'city'     =>['type'=>'select', 'label'=>'所在城市', 'valid'=>['成都'=>1, '深圳'=>2, '上海'=>'3']],
            'summary'  =>['type'=>'textarea', 'label'=>'说明'],
        ];
        $data = [
            'name'    => '二哈',
            'gender'  => 2,
            'hoby'    => [1,2],
            'city'    => 3,
            'summary' => 'introducation'
        ];
        $form = FormActive::setHint('has-success', ['name'=>'不能少于三个字', 'city'=>'未选择城市'])->render($options, $data);

        return $this->fetch('', ['form'=>$form]);
    }

    public function editor()
    {
        return $this->fetch();
    }

    public function category()
    {
        dump(model('Category')->buildWithIndentation());
    }

    public function getData()
    {
        $post = $this->request->post();
        return success($post);
    }
}