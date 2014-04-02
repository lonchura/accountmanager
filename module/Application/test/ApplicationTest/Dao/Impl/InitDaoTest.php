<?php
/**
 * Account Manager System (https://github.com/PsyduckMans/accountmanager)
 *
 * @link      https://github.com/PsyduckMans/accountmanager for the canonical source repository
 * @copyright Copyright (c) 2014 PsyduckMans (https://ninth.not-bad.org)
 * @license   https://github.com/PsyduckMans/accountmanager/blob/master/LICENSE MIT
 * @author    Psyduck.Mans
 */

namespace ApplicationTest\Dao\Impl;

/**
 * Class InitDaoTest
 * @package ApplicationTest\Dao\Impl
 */
class InitDaoTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var \Application\Auth\Crypt
     */
    protected $cryptGenerator;

    protected static $demoRole = array(
        'id' => 1,
        'name' => '管理员'
    );

    protected static $demoUser = array(
        'id' => 9,
        'name' => 'aqua',
        'nickname' => 'My oh my',
        'role_id' => 1,
        'password' => '123456'
    );
    protected static $demoUser2 = array(
        'id' => 10,
        'name' => 'aqua2',
        'nickname' => 'My oh my2',
        'role_id' => 1,
        'password' => '1234562'
    );

    protected static $demoAccount = array(
        'id' => 9,
        'user_id' => 9,
        'identifier' => 'www.google.com',
        'password' => '123456'
    );
    protected static $demoAccount2 = array(
        'id' => 10,
        'user_id' => 9,
        'identifier' => 'developer.apple.com',
        'password' => '1234562'
    );

    /**
     * setUp
     */
    protected function setUp()
    {
        parent::setUp();
        $this->cryptGenerator = \Bootstrap::getServiceManager()->get('Accountmanager\Auth\Crypt');
        $conn = \Propel::getConnection();
        $conn->beginTransaction();
        try {
            $this->initRole($conn);
            $this->initUser($conn);
            $this->initAccount($conn);
            $conn->commit();
        } catch(\Exception $e) {
            if($conn->inTransaction()) {
                $conn->rollBack();
            }
            $this->assertFalse(true, $e->getMessage());
        }
    }
    /**
     * tearDown
     */
    protected function tearDown()
    {
        $conn = \Propel::getConnection();
        $conn->beginTransaction();
        try {
            $this->dropAccount($conn);
            $this->dropUser($conn);
            $this->dropRole($conn);
            $conn->commit();
        } catch(\Exception $e) {
            if($conn->inTransaction()) {
                $conn->rollBack();
            }
            $this->assertFalse(true, $e->getMessage());
        }
        parent::tearDown();
    }

    private function initRole(\PDO $conn) {
        $datetime = date('Y-m-d H:i:s');
        $sql = "INSERT INTO `account_manager`.`role` (`id`, `name`, `create_time`, `update_time`) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $ret = $stmt->execute(array(
            self::$demoRole['id'],
            self::$demoRole['name'],
            $datetime,
            $datetime
        ));
    }
    private function dropRole(\PDO $conn)
    {
        $conn->exec('DELETE FROM account_manager.role');
    }

    private function initUser(\PDO $conn)
    {
        $datetime = date('Y-m-d H:i:s');
        $sql = sprintf("INSERT INTO `account_manager`.`user` (`id`, `name`, `nickname`, `role_id`, `password`, `create_time`, `update_time`) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt = $conn->prepare($sql);
        $ret = $stmt->execute(array(
            self::$demoUser['id'],
            self::$demoUser['name'],
            self::$demoUser['nickname'],
            self::$demoUser['role_id'],
            $this->cryptGenerator->create(self::$demoUser['password']),
            $datetime,
            $datetime
        ));
        $ret = $stmt->execute(array(
            self::$demoUser2['id'],
            self::$demoUser2['name'],
            self::$demoUser2['nickname'],
            self::$demoUser2['role_id'],
            $this->cryptGenerator->create(self::$demoUser2['password']),
            $datetime,
            $datetime
        ));
    }
    private function dropUser(\PDO $conn)
    {
        $conn->exec('DELETE FROM account_manager.user');
    }

    private function initAccount(\PDO $conn)
    {
        $datetime = date('Y-m-d H:i:s');
        $sql = sprintf("INSERT INTO `account_manager`.`account` (`id`, `user_id`, `identifier`, `password`, `create_time`, `update_time`) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt = $conn->prepare($sql);
        $ret = $stmt->execute(array(
            self::$demoAccount['id'],
            self::$demoUser['id'],
            self::$demoAccount['identifier'],
            self::$demoAccount['password'],
            $datetime,
            $datetime
        ));
        $ret = $stmt->execute(array(
            self::$demoAccount2['id'],
            self::$demoUser['id'],
            self::$demoAccount2['identifier'],
            self::$demoAccount2['password'],
            $datetime,
            $datetime
        ));
    }
    private function dropAccount(\PDO $conn)
    {
        $conn->exec('DELETE FROM account_manager.account');
    }
}
 