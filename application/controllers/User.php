<?php
/**
 * 首页测试
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-04-15
 */
class UserController extends \Cores\Controller {

    /**
     * 渲染 http://demo.yafapplication.loc/user/list
     * @return [type] [description]
     */
    public function listAction() {
        $this->getView()->assign('page', 1);
        $this->getView()->assign('name', 'Lancer He');
    }


    /**
     * 保存 
     * @return [type] [description]
     */
    public function saveAction() {
        $sex = $this->getRequest()->getPost("sex");
        if ( 1 == $sex ) {
            $this->getView()->assign("sex", 'male');
        }
    }


    /**
     * 更新 http://demo.yafapplication.loc/user/update?action=resetpassword
     * @return [type] [description]
     */
    public function updateAction() {
        $action = $this->getRequest()->getQuery('action');
        $this->getView()->assign("action", $action);
    }


    /**
     * 更新 http://demo.yafapplication.loc/index/view/id/4
     * @return [type] [description]
     */
    public function viewAction($id = 0) {
        $id = intval( $id );
        $this->getView()->assign("id", $id);
    }


    /**
     * 发送请求
     * @return [type] [description]
     */
    public function sendAction() {
        \Yaf\Dispatcher::getInstance()->disableView();

        // 建立请求类
        $request = new \Services\Http\Request\Curl();
        $request = new \Services\Http\Request\Decorator\Material($request);
        $request = new \Services\Http\Request\Decorator\Retry($request);
        $request = new \Services\Http\Request\Decorator\LoggerFile($request);

        // Get 请求下面的控制器
        $request->sendRequest(null, "http://demo.yafapplication.loc/user/receive");
        $response = $request->parseResponse();
        $this->getView()->assign('response', $response);
    }


    /**
     * 接受请求[模拟服务端用]
     * @return [type] [description]
     */
    public function receiveAction() {
        \Yaf\Dispatcher::getInstance()->disableView();

        echo json_encode(array("id" => 2, 'sex' => 1));
    }


    /**
     * 自定义正则路由   http://demo.yafapplication.loc/user-255-2.html?tip=2&name=lancer
     * @return [type] [description]
     */
    public function regexAction() {
        \Yaf\Dispatcher::getInstance()->disableView();

        $id   = $this->getRequest()->getParam('id');
        $page = $this->getRequest()->getParam('page');

        if ( $this->getRequest()->getQuery('tip') ) {
            $this->getView()->assign("tip", $this->getRequest()->getQuery('tip') );
        }

        if ( $this->getRequest()->getQuery('name') ) {
            $this->getView()->assign("name", $this->getRequest()->getQuery('name') );
        }

        $this->getView()->assign("id", $id);
        $this->getView()->assign("page", $page);
    }


    /**
     * 创建用户 抛出一个异常   http://demo.yafapplication.loc/user/add
     * @return [type] [description]
     */
    public function addAction() {
        \Yaf\Dispatcher::getInstance()->disableView();
        //new \Services\Http\Request\Exception\TimeoutException();
        $model = new UserModel();
        $model->addRow();
    }


    /**
     * 删除用户 抛出一个异常
     * @return [type] [description]
     */
    public function deleteAction() {
        \Yaf\Dispatcher::getInstance()->disableView();

        $model = new UserModel();
        try {
            $model->deleteRow();
        } catch ( \Exception $exception ) {
            echo "I catch it. so I want to render for it specially.";
        }
    }


    /**
     * 默认异常处理机制
     * @param  Exception $exception
     * @return
     */
    public static function defaultExceptionHandler( $exception ) {
        echo "<pre>";
        print_r( $exception->getMessage() );
        echo " This error in controller. we must to render it.";
        echo "</pre>";
    }
}