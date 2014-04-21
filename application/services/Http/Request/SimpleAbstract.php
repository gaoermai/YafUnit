<?php
/**
 * 抽象HTTP请求类
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-03-23
 */
namespace Services\Http\Request;

abstract class SimpleAbstract {

    /**
     * 获取CURL Handler
     */
    abstract public function getHandler();


    /**
     * 获取response信息
     * @return mixed
     */
    abstract public function getResponse();


    /**
     * 设置response信息
     * @return mixed
     */
    abstract public function setResponse($response);


    /**
     * 发送HTTP请求
     * @param  array   $post  POST数据，null表示无post即GET请求
     * @param  string  $url   请求的URL地址，可以通过包装类指定一个URL
     */
    abstract public function sendRequest($post = null, $url = null);

    /**
     * 解析HTTP请求返回的response数据
     */
    abstract public function parseResponse();
}