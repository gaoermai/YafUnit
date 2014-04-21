<?php
/**
 * 数据库删除记录失败
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-04-18
 */
namespace Services\Exception;

class DbDeleteFailureException extends \Cores\Exception {

    protected $code = 1013;

    protected $message = "Delete from table failure.";

}