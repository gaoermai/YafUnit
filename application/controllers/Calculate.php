<?php

class CalculateController extends Yaf\Controller_Abstract
{
    public function indexAction()
    {
    }

    public function plusAction()
    {
        $v1 = 1;
        $v2 = 3;
        $this->getView()->assign('result', $v1 + $v2);

        return true;
    }
}
