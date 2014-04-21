<?php
/**
 * 数据库增加记录失败
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-04-18
 */
namespace Services\Exception;

class DbInsertFailureException extends \Cores\Exception {

    protected $code = 1012;

    protected $message = "Insert Database failure.";

}