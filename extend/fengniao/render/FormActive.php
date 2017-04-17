<?php
/**
 * Bootstrap 表单动态生成类
 *
 * @method string render(array $options, array $data = []) 内容渲染
 * @method string setHint(string $class, $data = []) 设置提示信息
 * @method object setLabelClass(string $class) 修改 label 宽度
 * @method object setFormClass(string $class) 配置 form 标签上的样式
 *
 * @create_time  2017-3-27
 * @update_time  2017-3-27
 */
namespace fengniao\render;

class FormActive
{
    protected static $inputDivClass = '8';

    protected static $formClass = 'horizontal'; // '' inline

    protected static $labelClass = 'col-sm-2 control-label'; //'' sr-only

    protected static $needWrap    = true;

    /** @var string 验证 class */
    protected static $hintClass = false; // has-success has-error has-warning
    /** @var array 提示信息 */
    protected static $hintData = [];
     /** @var string html字符串 */
    protected static $html = '';
    /** @var array 表单的值  */
    protected static $data = [];

    /** @var array 支持的字段类型 */
    private static $_fieldType = ['input', 'select', 'textarea'];

    /** @var array input 支持的 type 类型 */
    private static $_inputType = ['text', 'number', 'file', 'password', 'checkbox', 'radio', 'hidden'];

    /**
     * 渲染内容 返回 html 字符串
     *
     * options = [
     *     'name'=>['type'=>'input', 'inputType'=>'text', 'label'=>'姓名'],
     *     'password'=>['type'=>'input', 'inputType'=>'password', 'label'=>'密码'],
     *     'gender'=>['type'=>'input', 'inputType'=>'radio', 'label'=>'性别', 'valid'=>['男'=>1, '女'=>2]],
     *     'hoby'=>['type'=>'input', 'inputType'=>'checkbox', 'label'=>'爱好', 'valid'=>['音乐'=>1, '看书'=>2, '跑步'=>'3']],
     *     'city'=>['type'=>'select', 'label'=>'所在城市', 'valid'=>['成都'=>1, '深圳'=>2, '上海'=>'3']],
     *     'summary'=>['type'=>'textarea', 'label'=>'说明'],
     * ];
     *
     * data = [
     *     'name'=>'二哈', 'gender'=>1, 'hoby'=>[1,2], 'city'=>1, 'summary'=>'个人说明'
     * ];
     * 
     * @param  array $options 参数配置
     * @param  array  $data    表单数据 
     * @return string
     */
    public static function render($options, $data = [])
    {
        self::$data = $data;
        $method = '';
        // 方法参数初始化
        $label = $id = $class = '';
        $attr = $valid = [];
        foreach ($options as $fieldName=>$option) {
            // 方法参数处理
            $label = $option['label'];
            $id    = 'Input'.ucfirst($fieldName);
            $class = isset($option['class']) ? $option['class'] : '';
            $attr  = isset($option['attr']) ? $option['attr'] : '';
            $valid = isset($option['valid']) ? $option['valid'] : [];

            if ($option['type'] == 'input') {
                $method = '_renderInput'.ucfirst($option['inputType']);
                if (in_array($option['inputType'], ['radio', 'checkbox'])) { // 单选  多选
                    self::renderItem($label, $id, $fieldName, self::$method($fieldName, $label, $option['inputType'], $class, $attr, $valid));
                } else {
                    self::renderItem($label, $id, $fieldName, self::$method($fieldName, $id, $label, $option['inputType'], $class, $attr));
                }
            } else {
                if ($option['type'] == 'textarea') {
                    self::renderItem($label, $id, $fieldName, self::_renderTextarea($fieldName, $id, $class, $attr));
                } elseif ($option['type'] == 'select') {
                    self::renderItem($label, $id, $fieldName, self::_renderSelect($fieldName, $id, $class, $attr, $valid));
                }
            }

        }
        return self::$html;
    }

    /**
     * 设置提示信息及样式
     * @param string $class 样式名 ['has-success', 'has-error', 'has-warning']
     * @param array  $data  提示信息
     * @return obj
     */
    public static function setHint($class, $data = [])
    {
        if (in_array($class, ['has-success', 'has-error', 'has-warning'])) {
            self::$hintClass = $class;
            self::$hintData  = $data;
        }
        return new static();
    }

    /**
     * 设置 label 上的class  主要修改宽度 默认 col-sm-2
     * @param string $class
     * @return object
     */
    public static function setLableClass($class)
    {
        self::$labelClass = $class;
        return new static();
    }

    /**
     * 设置 form 标签上的 class
     * @access public
     * @param string $class  ['', 'horizontal', 'inline']
     * @return object
     */
    public static function setFormClass($class)
    {
        if (in_array($class, ['', 'horizontal', 'inline'])) {
            self::$formClass = $class;
            $class != 'horizontal' && self::init();
        }
        return new static();
    }

    /**
     * 初始化配置参数
     * formClass
     * labelClass
     * needWrap
     * @return void
     */
    protected static function init()
    {
        if (self::$formClass) {
            switch (self::$formClass) {
                case 'horizontal' :
                        self::$labelClass = 'control-label';
                        self::$needWrap    = true;
                        break;
                case 'inline' :
                        self::$labelClass = 'sr-only';
                        self::$needWrap    = false;
                        break;
            }
        } else {
            self::$labelClass = '';
            self::$needWrap    = false;
        }
    }

    /**
     * 拼接一段内容
     * @param  string $label   显示名
     * @param  string $id      字段ID
     * @param  string $content 主体内容
     * @return string          self::$html 追加值
     */
    protected static function renderItem($label, $id, $name, $content)
    {
        $html = self::_formGroupBegin($name);
        $html .= self::_renderLabel($label, $id);
        $html .= self::_wrapBegin();
        $html .= $content;
        $html .= self::_renderHint($name);
        $html .= self::_wrapEnd();
        $html .= self::_formGroupEnd();
        self::$html .= $html;
    }

    /** 渲染 INPUT:TEXT */
    private static function _renderInputText($fieldName, $id, $label, $type, $class = '', $attr = [])
    {
        return self::_renderInputBase($fieldName, $id, $label, 'text', $class, $attr);
    }

    /** 渲染 INPUT:NUMBER */
    private static function _renderInputNumber($fieldName, $id, $label, $type, $class = '', $attr = [])
    {
        return self::_renderInputBase($fieldName, $id, $label, 'number', $class, $attr);
    }

    /** 渲染 INPUT:FILE */
    private static function _renderInputFile($fieldName, $id, $label, $type, $class = '', $attr = [])
    {
        return self::_renderInputBase($fieldName, $id, $label, 'file', $class, $attr);
    }

    /** 渲染 INPUT:PASSWORD */
    private static function _renderInputPassword($fieldName, $id, $label, $type, $class = '', $attr = [])
    {
        return self::_renderInputBase($fieldName, $id, $label, 'password', $class, $attr);
    }

    /** 渲染隐藏域 */
    private static function _renderInputHidden($fieldName, $id, $label, $type, $class = '', $attr = [])
    {
        return self::_renderInputBase($fieldName, $id, $label, 'hidden', $class, $attr);
    }

    /** 渲染 CHECKBOX */
    private static function _renderInputCheckbox($name, $label = '', $type = 'checkbox', $class = '', $attr = [], $valid = [])
    {
        $class = $class ? 'class="'. $class. '"' :'';
        $attr = self::_formatAttr($attr);

        $checkedValue = isset(self::$data[$name]) ? self::$data[$name] : [];
        $checked = '';

        $html = '<div class="checkbox" '. $attr .'>'."\n";
        foreach ($valid as $v=>$label) {
            $checked = in_array($v, $checkedValue) ? 'checked' : '';
            $html .= sprintf('<label><input type="checkbox" name="%s" value="%s" %s>%s</label>', $name, $v, $checked, $label). "\n";
        }
        $html .= '</div>'."\n";
        return $html;
    }

    /** 渲染 RADIO */
    private static function _renderInputRadio($name, $label = '', $type = 'radio', $class = '', $attr = [], $valid = [])
    {
        $class = $class ? 'class="'. $class. '"' :'';
        $attr = self::_formatAttr($attr);

        $checkedValue = isset(self::$data[$name]) ? self::$data[$name] : false;
        $checked = '';

        $html = '<div class="radio" ' .$attr. '>'. "\n";
        foreach ($valid as $v=>$label) {
            $checked = $v == $checkedValue ? 'checked' : '';
            $html .= sprintf('<label><input type="radio" name="%s" value="%s" %s>%s</label>', $name, $v, $checked, $label). "\n";
        }
        $html .= '</div>'."\n";
        return $html;
    }

    /** 渲染 TEXTAREA */
    private static function _renderTextarea($name, $id, $class, $attr = [])
    {
        $curValue = isset(self::$data[$name]) ? self::$data[$name] : '';
        $class    = $class ? 'form-control '.$class : 'form-control';
        $attr = self::_formatAttr($attr);
        return sprintf('<textarea name="%s" id="%s" class="%s" rows="3" %s>%s</textarea>', $name, $id, $class, $attr, $curValue)."\n";
    }

    /**
     * 渲染 SELECT
     * @param  string $name  字段名
     * @param  string $id    字段ID
     * @param  string $class 样式
     * @param  array $attr   附加标签
     * @param  array $valid  可用值
     * @return string
     */
    private static function _renderSelect($name, $id, $class, $attr, $valid)
    {
        $curValue = isset(self::$data[$name]) ? self::$data[$name] : '';
        $class    = $class ? 'form-control '.$class : 'form-control';
        $attr = self::_formatAttr($attr);
        $selected = '';
        $html = sprintf('<select name="%s" id="%s" class="%s" %s>', $name, $id, $class, $attr). "\n";
        foreach ($valid as $v=>$label) {
            $selected = $curValue == $v ? 'selected' : '';
            $html .= '<option value="'.$v .'" '.$selected .'>'.$label .'</option>'. "\n";
        }
        $html .= '</select>'. "\n";
        return $html;
    }

    /**
     * INPUT 基本构建
     * @param  string $name  字段名
     * @param  string $id    字段 ID
     * @param  string $label 显示名
     * @param  string $type  input:type
     * @param  string $class 附加 class
     * @param  array  $attr  附加标签
     * @return string
     */
    private static function _renderInputBase($name, $id, $label, $type, $class = '', $attr = [])
    {
        $curValue = isset(self::$data[$name]) ? self::$data[$name] : '';
        $class    = $class ? 'form-control '.$class : 'form-control';
        $type == 'hidden' && $class = ''; // 隐藏域，去除 class
        $attr = self::_formatAttr($attr);
        return sprintf('<input type="%s" name="%s" id="%s" class="%s" value="%s" %s>'
                , $type, $name, $id, $class, $curValue, $attr
            )."\n";
    }

    /**
     * 渲染 label 标签
     * @param  string $label 标签名
     * @param  string $id    input ID
     * @return string
     */
    private static function _renderLabel($label = '', $id = '') 
    {
        $id = $id ? 'for="'.$id .'"' : '';
        return sprintf('<label %s class="%s">%s</label>',
            $id, self::$labelClass, $label
            )."\n";
    }

    /**
     * 渲染提示信息
     * @param  string $name 字段名
     * @return string
     */
    private static function _renderHint($name)
    {
        $hint = isset(self::$hintData[$name]) ? self::$hintData[$name] : '';
        return $hint ? sprintf('<span class="help-block">%s</span>%s', $hint, "\n") : '';
    }

    /**
     * form group begin
     * @return string 
     */
    private static function _formGroupBegin($name)
    {   
        $hintClass = isset(self::$hintData[$name]) ? self::$hintClass : '';
        return sprintf('<div class="form-group %s">%s', $hintClass, "\n");
    }

    /**
     * form group end
     * @return string
     */
    private static function _formGroupEnd()
    {
        return '</div>';
    }

    /**
     * div wrap begin
     * @return string
     */
    private static function _wrapBegin()
    {
        return self::$needWrap ? '<div class="col-sm-'. self::$inputDivClass.'">'."\n" : '';
    }

    /**
     * div wrap end
     * @return string
     */
    private static function _wrapEnd()
    {
        return self::$needWrap ? "</div>\n" : '';
    }

    /**
     * @access private
     *
     * 处理标签附加属性 
     * @param  array $attr 标签配置
     * @return string
     */
    private static function _formatAttr($attr = [])
    {
        $res = '';
        if (is_array($attr) && !empty($attr)) {
            foreach ($attr as $data=>$value) {
                $res .= $value ? ' '. $data. '='. $value : ' '. $data;
            }
        }
        return $res;
    }
   
}