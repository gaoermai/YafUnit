<?php
/**
 * Bootstrap类中, 以_init开头的方法, 都会按顺序执行
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-04-15
 * @see    http://www.php.net/manual/en/class.yaf-bootstrap-abstract.php
 */
class Bootstrap extends \Yaf\Bootstrap_Abstract{

    /**
     * 初始化常量
     * @param  Yaf\Dispatcher $dispatcher  Yaf调度器
     * @return void
     */
    public function _initConst( Yaf\Dispatcher $dispatcher ) {
        define('APPLICATION_INI_PREFIX', 'application.moborobo_cp');
        define('APPLICATION_VIEWS_PATH',  APPLICATION_PATH . '/views');
        define('APPLICATION_CONFIG_PATH', APPLICATION_PATH . '/config');
    }


    /**
     * 初始化Config信息
     * @param  Yaf\Dispatcher $dispatcher  Yaf调度器
     * @return void
     */
    public function _initConfig( Yaf\Dispatcher $dispatcher ) {
        $config = $dispatcher->getApplication()->getConfig();
        // 保存一个全局配置文件到调度器上
        $dispatcher->config = new Yaf\Config\Simple(array(), false);
        $dispatcher->config->application = $config->application;
    }


    /**
     * 初始化异常操作
     * @param  Yaf\Dispatcher $dispatcher  Yaf调度器
     * @return void
     */
    public function _initException( Yaf\Dispatcher $dispatcher ) {
        // 抛出异常，不使用\Yaf\ErrorController接收，通过\Cores\ExceptionHandler处理
        \Yaf\Dispatcher::getInstance()->throwException(true);
        \Yaf\Dispatcher::getInstance()->catchException(false);
        set_exception_handler( array(new \Cores\ExceptionHandler(), 'handler') );
    }


    /**
     * 初始化本地类库
     * @param  Yaf\Dispatcher $dispatcher  Yaf调度器
     * @return void
     */
    public function _initLibrary( Yaf\Dispatcher $dispatcher ) {
        //注册本地类前缀
        $namespace = $dispatcher->config->application->library->localnamespace;
        $namespace = explode(',', $namespace);
        \Yaf\Loader::getInstance()->registerLocalNamespace( $namespace );
    }


    /**
     * 初始化视图相关
     * @param  Yaf\Dispatcher $dispatcher  Yaf调度器
     * @return void
     */
    public function _initView( Yaf\Dispatcher $dispatcher ) {
        $view = new Cores\View( APPLICATION_VIEWS_PATH, array() );
        $dispatcher->setView($view);
    }


    /**
     * 初始化路由配置
     * @param  Yaf\Dispatcher $dispatcher  Yaf调度器
     * @return void
     */
    public function _initRoute( Yaf\Dispatcher $dispatcher ) {
        //注册路由
        $config = new Yaf\Config\Ini( APPLICATION_CONFIG_PATH . "/routes.ini" );
        if ( empty($config->routes) )
            return ;
        
        $dispatcher->config->routes = $config->routes;
        $dispatcher->getRouter()->addConfig($config->routes);
    }
}
