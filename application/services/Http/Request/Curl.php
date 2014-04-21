<?php
/**
 * HTTP CURL 请求类 继承Http_Request_Abstract 装饰者模式
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-03-23
 */
namespace Services\Http\Request;

use Services\Http\Request\SimpleAbstract;

class Curl extends SimpleAbstract {

    /**
     * CURL handler
     * @var resouser
     */
    protected $_handler;


    /**
     * Http请求后服务端返回的response
     * @var mixed
     */
    protected $_response = NULL;


    /**
     * 初始化CURL请求Handler
     */
    public function __construct() {
        $this->_handler        = curl_init();
    }


    /**
     * 获取CURL Handler
     * @return resource
     */
    public function getHandler() {
        return $this->_handler;
    }


    /**
     * 获取response信息
     * @return mixed
     */
    public function getResponse() {
        return $this->_response;
    }


    /**
     * 设置response信息
     * @param mixed $response
     */
    public function setResponse($response) {
        $this->_response = $response;
    }


    /**
     * 发送HTTP请求
     * @param  array   $post  POST数据，null表示无post即GET请求
     * @param  string  $url   请求的URL地址，可以通过包装类指定一个URL
     * @return void
     */
    public function sendRequest($post = null, $url = null) {
        if ( $url ) {
            curl_setopt( $this->_handler, CURLOPT_URL, $url );
        }

        if ( $post ) {
            $post = is_array($post) ? http_build_query($post) : $post;
            curl_setopt( $this->_handler, CURLOPT_POST, 1 );
            curl_setopt( $this->_handler, CURLOPT_POSTFIELDS, $post );
        }

        curl_setopt( $this->_handler, CURLOPT_RETURNTRANSFER, true);

        $this->_response = curl_exec( $this->_handler );
    }


    /**
     * 解析HTTP请求返回的response数据
     * @return mixed
     */
    public function parseResponse() {
        return $this->_response;
    }
}