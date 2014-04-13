<?php

date_default_timezone_set("Asia/Shanghai");

define("WEBROOT_PATH", realpath(dirname(__FILE__).'/..'));
define("APP_PATH", WEBROOT_PATH.'/application');
define("VENDOR_PATH", realpath(WEBROOT_PATH.'/vendor'));

require_once VENDOR_PATH.'/autoload.php';

$app  = new Yaf\Application(APP_PATH."/conf/application.ini");

if (!defined('IN_YafUnit')) {
    $app->bootstrap()->run();
}
