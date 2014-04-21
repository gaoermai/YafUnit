<?php
/**
 * User Model
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-04-15
 */
Class UserModel extends \Cores\Model {

    /**
     * 根据ID返回行
     * @param  interger  $id
     * @return array
     */
    public function fetchRowById($id) {
        // So connect to mysql

        $row = array(
            'id'   => "5",
            'name' => 'Lancer He',
            'sex'  => "1",
        );
        return $row;
    }


    /**
     * 返回计算行
     * @return int
     */
    public function fetchCount() {
        // So connect to mysql
        return 1600;
    }


    /**
     * 插入行
     */
    public function addRow() {
        // so insert to mysql.
        $result = false;
        if ( ! $result ) {
            throw new \Cores\Exception\DbInsertFailureException();
        }
    }


    /**
     * 删除行
     * @return [type] [description]
     */
    public function deleteRow() {
        // so delelt from mysql table.
        $result = false;
        if ( ! $result ) {
            throw new \Cores\Exception\DbDeleteFailureException();
        }
    }


    /**
     * 默认异常处理机制
     * @param  YafException $exception [description]
     * @return [type]                  [description]
     */
    public static function defaultExceptionHandler( \Yaf\Exception $exception ) {
        echo "<pre>";
        echo $exception->getMessage();
        echo " so we need to log it.";
        echo "</pre>";
    }
}