<?php

class CalculateTest extends YafUnit_TestCase
{
    public function testPlusOne()
    {
        $this->assertEquals(1, self::$_view->result);
    }
}
