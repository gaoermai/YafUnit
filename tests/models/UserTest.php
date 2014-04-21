<?php
/**
 * User Model Test
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-04-15
 */
namespace YafUnit\Test\Model;

use YafUnit\TestCase;

class UserModelTest extends TestCase {

    /**
     * 测试fetchRowById方法
     * @return [type] [description]
     */
    public function testFetchRowById() {
        $id    = 4;
        $model = new \UserModel();
        $row   = $model->fetchRowById($id);

        $this->assertInternalType('string', $row['name']);
        $this->assertStringMatchesFormat('%i', $row['id']);
        $this->assertStringMatchesFormat('%i', $row['sex']);
    }


    /**
     * 测试fetchCount方法
     * @return [type] [description]
     */
    public function testFetchCount() {
        $model = new \UserModel();
        $count = $model->fetchCount();

        $this->assertEquals(18600, $count);
    }
}