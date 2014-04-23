<?php
/**
 * User Controller Test
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-04-15
 */
namespace YafUnit\Test\Controller;

use YafUnit\TestCase;
use YafUnit\RequestSimple;
use YafUnit\RequestHttp;

class UserTest extends TestCase {

    public function testListAction() {
        $request = new RequestSimple("GET", "Index", "User", 'List');

        self::$_app->getDispatcher()->dispatch($request);

        $this->assertEquals('Lancer He', self::$_view->name);
        $this->assertEquals(1,           self::$_view->page);
    }


    /**
     * Post方式
     * @return [type] [description]
     */
    public function testSaveAction() {
        $request = new RequestSimple("POST", "Index", "User", 'Save');
        $request->setPost('sex', 1);

        self::$_app->getDispatcher()->dispatch($request);

        $this->assertEquals('male', self::$_view->sex);
    }


    /**
     * Get方式
     * @return [type] [description]
     */
    public function testUpdateAction() {
        $request = new RequestSimple("GET", "Index", "User", 'Update');
        $request->setQuery('action', 'resetpassword');

        self::$_app->getDispatcher()->dispatch($request);

        $this->assertEquals('resetpassword', self::$_view->action);
    }


    /**
     * View方式
     * @return [type] [description]
     */
    public function testViewAction() {
        $request = new RequestSimple("GET", "Index", "User", 'View', array('id' => 1) );

        self::$_app->getDispatcher()->dispatch($request);

        $this->assertEquals(1, self::$_view->id);
    }


    /**
     * 测试Send Action service
     * @return [type] [description]
     */
    /*public function testSendAction() {
        $request = new RequestSimple("GET", "Index", "User", 'Send');
        self::$_app->getDispatcher()->dispatch($request);

        $this->assertEquals(1, self::$_view->response->id);
        $this->assertEquals(1, self::$_view->response->sex);
    }*/


    /**
     * Route方式
     * @return [type] [description]
     */
    public function testRegexAction() {
        $request = new RequestSimple("GET", "Index", "User", 'Regex', array('id' => 1, 'page'=>4) );

        self::$_app->getDispatcher()->dispatch($request);
        $this->assertEquals(1, self::$_view->id);
        $this->assertEquals(4, self::$_view->page);
    }


    /**
     * 测试正则路由方式
     * @return [type] [description]
     */
    public function testRegexRountAction() {
        $request = new RequestHttp("/user-255-2.html?tip=1&name=lancer");

        self::$_app->getDispatcher()->dispatch($request);

        $this->assertEquals(1,        self::$_view->tip);
        $this->assertEquals('lancer', self::$_view->name);
        $this->assertEquals(255,      self::$_view->id);
        $this->assertEquals(2,        self::$_view->page);
    }


    /**
     * 测试测试异常
     * @expectedException \Cores\Exception\DbInsertFailureException
     * @return [type] [description]
     */
    public function testAddAction() {
        $request = new RequestHttp("/user/add");

        self::$_app->getDispatcher()->dispatch($request);
    }
}