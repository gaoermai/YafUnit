<?php
/**
 * HTTP请求装饰类
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-03-23
 */
namespace Services\Http\Request\Decorator;

use Services\Http\Request\SimpleAbstract;
use Services\Http\Request\Decorator;

Class Material extends Decorator {
    // 装饰创建请求
    public function sendRequest($post = NULL, $url = NULL) {
        // 设置请求信息
        curl_setopt($this->getHandler(), CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($this->getHandler(), CURLOPT_TIMEOUT, 3);

        parent::sendRequest($post, $url);
    }

    // 解析response数据
    public function parseResponse() {
        $response = $this->getResponse();
        $this->setResponse( json_decode($response) );
        return parent::parseResponse();
    }
}