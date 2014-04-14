<?php

define('IN_YafUnit', true);


final class YafUnit_Request extends Yaf\Request_Abstract
{
    public function __construct($method, $module, $controller, $action, $params = null)
    {
        $this->method     = $method;
        $this->module     = $module;
        $this->controller = $controller;
        $this->action     = $action;
        $this->params     = $params;
        $this->__setParams();
    }

    public function getQuery($name = null)
    {
        if (is_null($name)) return $_GET;
        return isset($_GET[$name]) ? $_GET[$name] : null;
    }

    public function getPost($name = null)
    {
        if (is_null($name)) return $_POST;
        return isset($_POST[$name]) ? $_POST[$name] : null;
    }

    public function getCookie($name = null)
    {
        if ( is_null($name) ) return $_COOKIE;
        return isset($_COOKIE[$name]) ? $_COOKIE[$name] : null;
    }

    public function getFiles($name = null)
    {
        if (is_null($name)) return $_FILES;
        return isset($_FILES[$name]) ? $_FILES[$name] : null;
    }

    public function getServer($name, $default = null)
    {

    }

    public function getEnv($name, $default = null)
    {

    }

    public function setPost($name, $value)
    {
        $_POST[$name] = $value;
    }

    public function setQuery($name, $value)
    {
        $_GET[$name] = $value;
    }

    public function setCookie($name, $value)
    {
        $_COOKIE[$name] = $value;
    }

    public function setSession($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    public function getModuleName()
    {
        return $this->module;
    }

    public function getControllerName()
    {
        return $this->controller;
    }

    private function __setParams()
    {
        if (!empty ($this->params) && is_array($this->params)) {
            foreach ($this->params as $key => $value) {
                if ($this->method == 'POST') {
                    $this->setPost($key, $value);
                } else {
                    $this->setQuery($key, $value);
                }
            }
        }
    }
}

final class YafUnit_View implements Yaf\View_Interface
{

    private $__tpl_vars = array();

    private static $__instance = null;

    private function __construct() {}

    public static function getInstance()
    {
        if(!self::$__instance) {
            self::$__instance = new self;
        }
        return self::$__instance;
    }

    public function setScriptPath($view_directory)
    {
        $this->_view_directory = $view_directory;
    }

    public function getScriptPath()
    {
        return $this->_view_directory;
    }

    public function get($key=null)
    {
        if (is_null($key)) return $this->__tpl_vars;

        return isset($this->__tpl_vars[$key]) ? $this->__tpl_vars[$key] : null;
    }

    public function __get($key)
    {
        return $this->get($key);
    }

    public function clear()
    {
        $this->__tpl_vars = array();
    }

    public function assign($spec, $value = null)
    {
        if (!is_array($spec)){
            $this->__tpl_vars[$spec] = $value;
            return;
        }

        foreach($spec AS $key => $value){
            $this->__tpl_vars[$key] = $value;
        }
    }

    public function render($view_path, $tpl_vars = null)
    {
        return false;
    }

    public function display( $view_path, $tpl_vars = null)
    {
        return false;
    }
}


class YafUnit_TestCase extends PHPUnit_Framework_TestCase
{
    protected $_app;
    protected static $_view;

    public function setUp()
    {
        if (!Yaf\Registry::get('Application')) {
            $this->__setUpYafApplication();
        }else {
            $this->_app = Yaf\Registry::get('Application');
        }
        if (!self::$_view) {
            self::$_view = YafUnit_View::getInstance();
        }
    }

    private function __setUpPHPIniVariables()
    {

    }

    private function __setUpYafApplication()
    {
        $this->__setUpPHPIniVariables();

        require_once __DIR__.'/../public/index.php';
        $this->_app = & $app;
        $this->_app->bootstrap();
        $this->_app->getDispatcher()->setView(YafUnit_View::getInstance());
        Yaf\Registry::set('Application', $this->_app);
    }
}
