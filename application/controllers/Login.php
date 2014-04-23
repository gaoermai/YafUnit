<?php
/**
 * 登陆测试
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-04-23
 */
class LoginController extends \Cores\Controller {

    /**
     * 查看session中是否登陆 http://yafapp.lancergithub.com/login/islogin
     * @return [type] [description]
     */
    public function isLoginAction() {
        \Yaf\Dispatcher::getInstance()->disableView();

        if ( \Cores\Session::getInstance()->get('login') ) {
            $this->getView()->assign('login', 1);
        } else {
            $this->getView()->assign('login', 0);
        }
    }
}