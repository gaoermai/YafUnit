<?php
/**
 * HTTP重试装饰类
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-03-23
 */
namespace Services\Http\Request\Decorator;

use Services\Http\Request\SimpleAbstract;
use Services\Http\Request\Decorator;

Class Retry extends Decorator {
    public function sendRequest($post = NULL, $url = NULL) {
        // 3秒超时
        curl_setopt( $this->getHandler(), CURLOPT_TIMEOUT, 3);

        parent::sendRequest($post, $url);

        // 状态码非200重试，因业务调整
        if ( 200 !== curl_getinfo( $this->getHandler(), CURLINFO_HTTP_CODE ) ) {
            $response = curl_exec( $this->getHandler() );
            $this->setResponse($response);
        }
    }
}