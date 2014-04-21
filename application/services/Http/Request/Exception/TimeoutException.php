<?php
/**
 * HTTP CURL 请求超时异常
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-04-18
 */
namespace Services\Http\Request\Exception;

class TimeoutException extends \Cores\Exception {

    protected $code = 10012;

    protected $message = "Request timeout 2s! can I say something to you?";

}