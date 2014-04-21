<?php
/**
 * HTTP 邮件日志策略
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-03-23
 */
namespace Services\Http\Request\Decorator;

use Services\Http\Request\SimpleAbstract;
use Services\Http\Request\Decorator;

Class LoggerEmail extends Decorator {

    protected $_content;

    protected $_send_to     = "lancer.he@gmail.com";

    protected $_smtp_server = 'smtp.126.com';

    protected $_smtp_user   = '';

    protected $_smtp_pass   = '';

    protected $_smtp_port   = 25;

    protected $_hooks = array();

    public function __construct(SimpleAbstract $http_request) {
        parent::__construct($http_request);

        $this->_content .= $this->_buildFormatTime() . " - Request Start." . PHP_EOL;
    }

    public function sendRequest($post = NULL, $url = NULL) {
        curl_setopt( $this->getHandler(), CURLINFO_HEADER_OUT, true);

        parent::sendRequest($post, $url);

        $this->_logDetail($post);
    }


    public function parseResponse() {
        $response = parent::parseResponse();
        $this->_content .= $this->_buildFormatTime() . " - Request Close." . PHP_EOL;
        $this->_send();
        return $response;
    }


    protected function _logDetail($post) {
        $time     = $this->_buildFormatTime();
        $request  = curl_getinfo( $this->getHandler() );
        $response = $this->getResponse();

        $this->_content .= 
            $this->_buildFormatTime() . " - Normal Request." . PHP_EOL
            . '[request_header] => '     . $request['request_header'] . PHP_EOL
            . '[request_body] => '       . (is_array($post) ? http_build_query($post) : $post) . PHP_EOL
            . '[response_http_code] => ' . $request['http_code'] . PHP_EOL
            . '[response_body] => '      . $response . PHP_EOL;
    }

    protected function _buildFormatTime() {
        return "[" . date("Y-m-d H:i:s") . "]";
    }

    protected function _send() {
        $smtp   = fsockopen($this->_smtp_server, $this->_smtp_port);
        $return = array();
        $return["CONN"] = fgets ( $smtp, 1024 ); 
        
        fputs($smtp, "helo 126.com\r\n");
        $return["HELO"] = fgets ( $smtp, 1024 ); 

        fputs($smtp, "auth login\r\n");
        $return["AUTH"] = fgets ( $smtp, 1024 ); 

        fputs($smtp, base64_encode($this->_smtp_user) . "\r\n");
        $return["USER"] = fgets ( $smtp, 1024 );

        fputs($smtp, base64_encode($this->_smtp_pass) . "\r\n");
        $return["PASS"] = fgets ( $smtp, 1024 );

        fputs($smtp, "MAIL FROM: <{$this->_smtp_user}>\r\n");
        $return["FROM"] = fgets ( $smtp, 1024 );

        fputs($smtp, "RCPT TO: <{$this->_send_to}>\r\n");
        $return["TO"] = fgets ( $smtp, 1024 );

        fputs($smtp, "DATA\r\n");
        $return["DATA"] = fgets ( $smtp, 1024 );

        fputs($smtp, "From: <{$this->_smtp_user}\r\n");
        fputs($smtp, "To: <{$this->_send_to}>\r\n");
        fputs($smtp, "Subject: PHP Email Logger\r\n\r\n\r\n");
        //Content
        fputs($smtp, "{$this->_content}\r\n.\r\n");
        $return["SEND"] = fgets ( $smtp, 256 );

        //Clost connection and exit... 
        fputs($smtp, "QUIT\r\n");
        fclose($smtp);

        return $return;
    }
}