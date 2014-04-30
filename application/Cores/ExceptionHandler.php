<?php
/**
 * 应用核心异常处理类 Cores\ExceptionHandler
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-04-17
 */
namespace Cores;

/**
 * Yaf自带异常
 * define YAF\ERR\STARTUP_FAILED      512
 * define YAF\ERR\ROUTE_FAILED        513
 * define YAF\ERR\DISPATCH_FAILED     514
 * define YAF\ERR\NOTFOUND\MODULE     515
 * define YAF\ERR\NOTFOUND\CONTROLLER 516
 * define YAF\ERR\NOTFOUND\ACTION     517
 * define YAF\ERR\NOTFOUND\VIEW       518
 * define YAF\ERR\CALL_FAILED         519
 * define YAF\ERR\AUTOLOAD_FAILED     520
 * define YAF\ERR\TYPE_ERROR          521
 */
class ExceptionHandler {

    /**
     * 将当前ExceptionHandler作为捕捉异常处理
     */
    public function __construct() {
        set_exception_handler(array($this, 'handler'));
    }


    /**
     * 处理异常函数, 追踪每个节点进行处理
     * @param  $exception  异常对象
     * @return void
     */
    public function handler( $exception ) {
        foreach ( $exception->getTrace() as $trace ) {
            if ( method_exists($trace['class'], 'defaultExceptionHandler' ) ) {
                call_user_func_array(
                    array( $trace['class'], 'defaultExceptionHandler' ), 
                    array( $exception, $this->getView() )
                );
                exit();
            }
        }

        $this->defaultExceptionHandler($exception );
    }


    /**
     * 错误模板渲染
     * @return [type] [description]
     */
    public function defaultExceptionHandler( $exception ) {
        $this->getView()->assign("exception", $exception);

        if ( in_array($exception->getCode(), array(
            \YAF\ERR\NOTFOUND\ACTION,
            \YAF\ERR\NOTFOUND\CONTROLLER,
            \YAF\ERR\NOTFOUND\MODULE,
            \YAF\ERR\NOTFOUND\VIEW,
            \YAF\ERR\AUTOLOAD_FAILED,
        )) ) {
            // 自定义错误
            $this->getView()->display('error/error_yaf.html');
        } else {
            $this->getView()->display('error/error.html');
        }
    }


    /**
     * 通过调度器initView方法可以返回\Cores\View核心视图对象
     * @return [type] [description]
     */
    public function getView() {
        return \Yaf\Dispatcher::getInstance()->initView( APPLICATION_VIEWS_PATH );
    }
}