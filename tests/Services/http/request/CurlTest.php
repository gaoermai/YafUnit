<?php
/**
 * Service Http request curl test
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-04-15
 */
namespace YafUnit\Test\Service\Http\Request;

use YafUnit\TestCase;

class CurlTest extends TestCase {

    public function testParseResponse() {
        $request = new \Services\Http\Request\Curl();
        $request->sendRequest(null, "http://yafapp.lancergithub.com/user/receive");
        $response = $request->parseResponse();

        $this->assertInternalType('string', $response);
        $this->assertEquals('{"id":2,"sex":1}', $response);
    }

}