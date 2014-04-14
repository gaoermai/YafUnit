<?php

class CalculateTest extends YafUnit_TestCase
{
    public function testPlusOne()
    {
        $request = new YafUnit_Request("GET", "", "calculate", 'plus', array());

        YafUnit_View::getInstance()->clear();
        $this->_app->getDispatcher()->dispatch($request);
        $this->assertEquals(4, self::$_view->result);
    }
}
