<?php
/**
 * 应用核心异常类 Cores\Exception
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-04-17
 */
namespace Cores;

class Exception extends \Exception{

    /**
     * [__construct description]
     * @param [type] $message  [description]
     * @param [type] $code     [description]
     * @param [type] $previous [description]
     */
    public function __construct( $message = null, $code = null, Exception $previous = null ) {
        $message = is_null($message) ? $this->message : $message;
        $code    = is_null($code)    ? $this->code    : intval($code);
        parent::__construct( $message, $code, $previous );
    }
}