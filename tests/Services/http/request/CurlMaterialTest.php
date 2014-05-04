<?php
/**
 * Service Http request curl test
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-04-15
 */
namespace YafUnit\Test\Service\Http\Request;

use YafUnit\TestCase;

class CurlMaterialTest extends TestCase {

    public function testParseResponse() {
        $request = new \Services\Http\Request\Curl();
        $request = new \Services\Http\Request\Decorator\Material($request);
        $request->sendRequest(null, "http://yafapp.lancergithub.com/user/receive");
        $response = $request->parseResponse();
        
        $this->assertEquals('2', $response->id);
        $this->assertEquals('1', $response->sex);
    }
}