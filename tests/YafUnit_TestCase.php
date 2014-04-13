<?php

define('IN_YafUnit', true);

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
    protected static $_app;
    protected static $_view;

    public function setUp()
    {
        if (!self::$_app) {
            $this->__setUpYafApplication();
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
        self::$_app = $app;
        self::$_app->getDispatcher()->setView(YafUnit_View::getInstance());

        Yaf\Registry::set('Application', self::$_app);
    }
}
