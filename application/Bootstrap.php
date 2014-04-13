<?php

class Bootstrap extends Yaf\Bootstrap_Abstract
{
    public function _initConfig()
    {
        //把配置保存起来
        $configure = Yaf\Application::app()->getConfig();
        Yaf\Registry::set('config', $configure);
    }

    public function _initPlugin(Yaf\Dispatcher $dispatcher)
    {

    }

    public function _initRoute(Yaf\Dispatcher $dispatcher)
    {

    }

    public function _initView(Yaf\Dispatcher $dispatcher)
    {

    }
}
