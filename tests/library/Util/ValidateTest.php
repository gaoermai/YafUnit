<?php
/**
 * Util_Validate Library Test
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-04-15
 */
namespace YafUnit\Test\Library;

use YafUnit\TestCase;

class UtilValidateTest extends TestCase {

    /**
     * 测试 isEmailAddr
     * @return [type] [description]
     */
    public function testIsEmailAddr() {
        $success = \Util_Validate::isEmailAddr( 'lancer.he@gmail.com' );
        $failure = \Util_Validate::isEmailAddr( 'lancer.hegmail.com' );

        $this->assertEquals(true, $success);
        $this->assertEquals(false, $failure);
    }


    /**
     * 测试 testIsHttpUrl
     * @return [type] [description]
     */
    public function testIsHttpUrl() {
        $success = \Util_Validate::isHttpUrl( 'http://www.baidu.com' );
        $failure = \Util_Validate::isHttpUrl( 'www.baidu.com' );

        $this->assertEquals(true, $success);
        $this->assertEquals(false, $failure);
    }
}