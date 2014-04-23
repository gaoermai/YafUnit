<?php
/**
 * Login Controller Test 
 * Session测试注意，当Session初始化时候会分配一个新的sessid，存放在/tmp/下
 * 每次phpunit测试只会产生一个sess文件
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-04-15
 */
namespace YafUnit\Test\Controller;

use YafUnit\TestCase;
use YafUnit\RequestSimple;
use YafUnit\RequestHttp;

class LoginTest extends TestCase {

    /**
     * 测试是否已经登陆的Seesion状态 [注意这里Session是模拟真实的Session写入一个文件]
     */
    public function testHasNotLogin() {
        $request = new RequestHttp("/login/islogin");
        \Cores\Session::getInstance()->login = 0;

        self::$_app->getDispatcher()->dispatch($request);
        $this->assertEquals(0, self::$_view->login);
    }


    /**
     * 测试是否已经登陆的Seesion状态 [注意这里Session是模拟真实的Session写入一个文件]
     */
    public function testHasLogin() {
        $request = new RequestHttp("/login/islogin");
        \Cores\Session::getInstance()->login = 1;

        self::$_app->getDispatcher()->dispatch($request);
        $this->assertEquals(1, self::$_view->login);
    }
}