<?php
/**
 * 应用核心异常处理类 Cores\ExceptionHandler
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-04-17
 */
namespace Cores;

/**
 * Yaf自带异常
 * define Yaf\MAX\BUILDIN\EXCEPTION   10
 * define Yaf\ERR\BASE                512
 * define Yaf\UERR\BASE               1024
 * define Yaf\ERR\MASK                127
 * define Yaf\ERR\STARTUP\FAILED      512
 * define Yaf\ERR\ROUTE\FAILED        513
 * define Yaf\ERR\DISPATCH\FAILED     514
 * define Yaf\ERR\NOTFOUND\MODULE     515
 * define Yaf\ERR\NOTFOUND\CONTROLLER 516
 * define Yaf\ERR\NOTFOUND\ACTION     517
 * define Yaf\ERR\NOTFOUND\VIEW       518
 * define Yaf\ERR\CALL\FAILED         519
 * define Yaf\ERR\AUTOLOAD_FAILED     520
 * define Yaf\ERR\TYPE\ERROR          521
 */
class ExceptionHandler {

    /**
     * 异常
     * @var Exception
     */
    protected $_exception = null;


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
                    array( $exception )
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
            \Yaf\ERR\NOTFOUND\ACTION,
            \Yaf\ERR\NOTFOUND\CONTROLLER,
            \Yaf\ERR\NOTFOUND\MODULE,
            \Yaf\ERR\NOTFOUND\VIEW,
            \Yaf\ERR\AUTOLOAD_FAILED,
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