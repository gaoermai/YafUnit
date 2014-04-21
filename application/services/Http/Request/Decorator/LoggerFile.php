<?php
/**
 * HTTP日志装饰类
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-03-23
 */
namespace Services\Http\Request\Decorator;

use Services\Http\Request\SimpleAbstract;
use Services\Http\Request\Decorator;

Class LoggerFile extends Decorator {

    protected $_output_file;

    public function __construct(SimpleAbstract $http_request) {
        parent::__construct($http_request);

        $this->_output_file = ROOT_PATH . '/logfile.log';
        $this->_output($this->_buildFormatTime() . " - Request Start." . PHP_EOL);
    }

    public function sendRequest($post = NULL, $url = NULL) {
        curl_setopt( $this->getHandler(), CURLINFO_HEADER_OUT, true);

        parent::sendRequest($post, $url);

        $this->_logDetail($post);
    }


    public function parseResponse() {
        $response = parent::parseResponse();
        $this->_output( $this->_buildFormatTime() . " - Request Close." . PHP_EOL);
        return $response;
    }


    protected function _logDetail($post) {
        $time     = $this->_buildFormatTime();
        $request  = curl_getinfo( $this->getHandler() );
        $response = $this->getResponse();

        $this->_output( 
            $this->_buildFormatTime() . " - Normal Request." . PHP_EOL
            . '[request_header] => '     . $request['request_header'] . PHP_EOL
            . '[request_body] => '       . (is_array($post) ? http_build_query($post) : $post) . PHP_EOL
            . '[response_http_code] => ' . $request['http_code'] . PHP_EOL
            . '[response_body] => '      . $response . PHP_EOL
        );
    }

    protected function _buildFormatTime() {
        return "[" . date("Y-m-d H:i:s") . "]";
    }

    protected function _output($string) {
        $handle = fopen($this->_output_file, 'a');
        flock($handle, LOCK_EX);
        fwrite($handle, $string);
        flock($handle, LOCK_UN);
        fclose($handle);
    }
}