<?php
/**
 * Account Manager System (https://github.com/PsyduckMans/accountmanager)
 *
 * @link      https://github.com/PsyduckMans/accountmanager for the canonical source repository
 * @copyright Copyright (c) 2014 PsyduckMans (https://ninth.not-bad.org)
 * @license   https://github.com/PsyduckMans/accountmanager/blob/master/LICENSE MIT
 * @author    Psyduck.Mans
 */

namespace Application\Dao\Impl;
use Propel\User;

/**
 * Class UserDaoTest
 * @package Application\Dao\Impl
 */
class UserDaoTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var \Application\Dao\UserDao
     */
    private $userDao;

    /**
     * @var \Application\Auth\Crypt
     */
    private $cryptGenerator;

    private static $demoRole = array(
        'id' => 1,
        'name' => '管理员'
    );
    private static $demoUser = array(
        'id' => 9,
        'name' => 'aqua',
        'nickname' => 'My oh my',
        'role_id' => 1,
        'password' => '123456'
    );
    private static $demoUser2 = array(
        'id' => 10,
        'name' => 'aqua2',
        'nickname' => 'My oh my2',
        'role_id' => 1,
        'password' => '1234562'
    );

    /**
     * setUp
     */
    protected function setUp()
    {
        parent::setUp();
        $this->cryptGenerator = \Application\Bootstrap::getServiceManager()->get('Accountmanager\Auth\Crypt');
        $this->initUser();
        $this->userDao = new \Application\Dao\Impl\UserDao();
    }
    /**
     * tearDown
     */
    protected function tearDown()
    {
        $this->dropUser();
        parent::tearDown();
    }

    public function testFindOneByName() {
        $user = $this->userDao->findOneByName(self::$demoUser['name']);
        $this->assertNotNull($user, 'Expect return not null');
        $this->assertInstanceOf('\Propel\User', $user, 'Is not instance of \Propel\User');
        $this->assertEquals(self::$demoUser['name'], $user->getName(), 'name unmatched');
        $this->assertEquals(self::$demoUser['nickname'], $user->getNickName(), 'nickname unmatched');
        $this->assertInternalType('int', $user->getRoleId(), 'role id type should be int');
        $this->assertEquals(self::$demoUser['role_id'], $user->getRoleId(), 'role id unmatched');
        $this->assertTrue($this->cryptGenerator->verify(self::$demoUser['password'], $user->getPassword()), 'password unmatched');
    }
    public function testFindOneByNotFoundName() {
        $user = $this->userDao->findOneByName('NotFoundName');
        $this->assertNull($user, 'Expect return null');
    }

    public function testGetUserById() {
        $user = $this->userDao->getUserById(self::$demoUser['id']);

        $this->assertNotNull($user, 'Expect return not null');
        $this->assertInstanceOf('\Propel\User', $user, 'Is not instance of \Propel\User');
        $this->assertEquals(self::$demoUser['name'], $user->getName(), 'name unmatched');
        $this->assertEquals(self::$demoUser['nickname'], $user->getNickName(), 'nickname unmatched');
        $this->assertInternalType('int', $user->getRoleId(), 'role id type should be int');
        $this->assertEquals(self::$demoUser['role_id'], $user->getRoleId(), 'role id unmatched');
        $this->assertTrue($this->cryptGenerator->verify(self::$demoUser['password'], $user->getPassword()), 'password unmatched');
    }
    public function testGetUserByNotFoundId() {
        $user = $this->userDao->getUserById(100);
        $this->assertNull($user, 'Expect return null');
    }

    public function testSave() {
        $expectUser = array(
            'name' => 'psyduck',
            'nickname' => 'Psyduck.Mans',
            'password' => 'IOH*(F#@(ad21=-'
        );
        $hashPassword = $this->cryptGenerator->create($expectUser['password']);

        $user = new User();
        $user->setName($expectUser['name']);
        $user->setNickname($expectUser['nickname']);
        $user->setPassword($hashPassword);
        $user->setRoleId(self::$demoRole['id']);

        $rowsAffected = $this->userDao->save($user);
        $this->assertEquals(1, $rowsAffected);
    }
    /**
     * @expectedException \Application\Dao\RuntimeException
     * @expectedExceptionMessage
     */
    public function testSaveException() {
        $user = new User();
        $user->setName(self::$demoUser['name']);
        $user->setNickname(self::$demoUser['nickname']);
        $user->setPassword('');
        $user->setRoleId(self::$demoRole['id']);

        $rowsAffected = $this->userDao->save($user);
    }

    public function testDeleteRangeByIds() {
        $expectedRowsAffected = 2;
        $rowsAffected = $this->userDao->deleteRangeByIds(array(
            self::$demoUser['id'],
            self::$demoUser2['id']
        ));
        $this->assertEquals($expectedRowsAffected, $rowsAffected, 'rows affected('.$rowsAffected.') not '.$expectedRowsAffected);
    }
    public function testDeleteRangeByNotFoundIds() {
        $expectedRowsAffected = 0;
        $rowsAffected = $this->userDao->deleteRangeByIds(array(100));
        $this->assertEquals($expectedRowsAffected, $rowsAffected, 'rows affected('.$rowsAffected.') not '.$expectedRowsAffected);
    }

    private function initUser()
    {
        $conn = \Propel::getConnection();
        $conn->beginTransaction();
        try {
            $datetime = date('Y-m-d H:i:s');
            $sql = "INSERT INTO `account_manager`.`role` (`id`, `name`, `create_time`, `update_time`) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $ret = $stmt->execute(array(
                self::$demoRole['id'],
                self::$demoRole['name'],
                $datetime,
                $datetime
            ));
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
            $conn->commit();
        } catch(\Exception $e) {
            if($conn->inTransaction()) {
                $conn->rollBack();
            }
            $this->assertFalse(true, $e->getMessage());
        }
    }
    private function dropUser()
    {
        $conn = \Propel::getConnection();
        $conn->beginTransaction();
        try {
            $conn->exec('DELETE FROM account_manager.user');
            $conn->exec('DELETE FROM account_manager.role');
            $conn->commit();
        } catch(\Exception $e) {
            if($conn->inTransaction()) {
                $conn->rollBack();
            }
            $this->assertFalse(true, $e->getMessage());
        }
    }
}
 