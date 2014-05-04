<?php
date_default_timezone_set("Asia/Shanghai");
define('ROOT_PATH',               dirname(dirname(__FILE__)));
define('PUBLIC_PATH',             ROOT_PATH . '/public');
define('VENDOR_PATH',             ROOT_PATH . '/vendor');
define('APPLICATION_PATH',        ROOT_PATH . '/application');
define('APPLICATION_IS_CLI',      (php_sapi_name() == 'cli') ? true : false);
define('APPLICATION_ENV_LOCAL',  'loc');
define('APPLICATION_ENV_DEVEL',  'dev');
define('APPLICATION_ENV_PRODUCT','com');

// 从php.ini中判断环境变量, 正式环境中不存在这个变量
$environment = get_cfg_var( 'application.environment' );
define('APPLICATION_ENVIRONMENT', in_array(
    $environment, 
    array(APPLICATION_ENV_LOCAL, APPLICATION_ENV_DEVEL, APPLICATION_ENV_PRODUCT) 
) ? $environment : APPLICATION_ENV_PRODUCT );

require_once VENDOR_PATH . "/autoload.php";

$application = new Yaf\Application( APPLICATION_PATH . "/config/application.ini", APPLICATION_ENVIRONMENT);
$application->bootstrap();

if ( ! defined('APPLICATION_NOT_RUN') ) {
    $application->run();
}
?>