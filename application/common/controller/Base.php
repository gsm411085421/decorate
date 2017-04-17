<?php
namespace app\common\controller;

use think\Request;
use think\View;
use think\Loader;
use think\Config;

class Base
{
    /**
     * 当前请求的数据表名
     * @var boolean
     */
    protected $table = false;
    /**
     * 当前模块名
     * @var string
     */
    protected $module;
    /**
     * @var \think\View 视图类实例
     */
    protected $view;
    /**
     * @var \think\Request Request实例
     */
    protected $request;

    public function __construct(Request $request = null)
    {
        if (is_null($request)) {
            $request = Request::instance();
        }
        $this->view    = View::instance(Config::get('template'), Config::get('view_replace_str'));
        $this->request = $request;

        // 控制器初始化
        $this->_initialize();
    }
/**
 * 初始化
 */
    protected function _initialize(){}


/**
 * 请求控制器名对应的数据模型类实例
 * @return Model
 */
    protected function model($table = '')
    {
        $table = $table ? : ($this->table ? : $this->request->controller());
        $module = $this->module ? : $this->request->module();

        $class = 'app\\'.$module.'\model\\'.$table;
        return new $class;
    }

/**
 * 加载模板输出
 * @access protected
 * @param string $template 模板文件名
 * @param array  $vars     模板输出变量
 * @param array  $replace  模板替换
 * @param array  $config   模板参数
 * @return mixed
 */
    protected function fetch($template = '', $vars = [], $replace = [], $config = [])
    {
        return $this->view->fetch($template, $vars, $replace, $config);
    }
}
