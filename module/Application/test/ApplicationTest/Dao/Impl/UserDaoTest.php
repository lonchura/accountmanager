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

require_once 'ApplicationTest/Dao/Impl/InitDaoTest.php';

use Propel\User;

/**
 * Class UserDaoTest
 * @package ApplicationTest\Dao\Impl
 */
class UserDaoTest extends InitDaoTest {

    /**
     * @var \Application\Dao\UserDao
     */
    private $userDao;

    /**
     * setUp
     */
    protected function setUp()
    {
        parent::setUp();
        $this->userDao = new \Application\Dao\Impl\UserDao();
    }
    /**
     * tearDown
     */
    protected function tearDown()
    {
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

    public function testFindNormal() {
        $page = array(
            'limit' => 50,
            'page' => 1,
            'sort' => null,
            'start' => 0
        );
        $pageResult = $this->userDao->find($page);
        $this->assertTrue(is_array($pageResult), 'Page result should be array type');
        $this->assertTrue(isset($pageResult['total']), 'Page result should has property "total"');
        $this->assertInternalType('int', $pageResult['total'], 'Page result property "total" type is not int');
        $this->assertTrue(isset($pageResult['list']), 'Page result should has property "list"');
        $this->assertInstanceOf('\PropelObjectCollection', $pageResult['list'], 'Page result property "list" type is not instance of \PropelObjectCollection');
        $this->assertEquals(2, count($pageResult['list']), 'Page result count unexpected on current context');
    }

    public function testFindSortDESC() {
        $page = array(
            'limit' => 50,
            'page' => 1,
            'sort' => array(
                array(
                    'property' => 'UserId',
                    'direction' => 'DESC'
                )
            ),
            'start' => 0
        );
        $pageResult = $this->userDao->find($page);
        $user = current($pageResult['list']);
        $this->assertEquals(self::$demoUser2['id'], $user->getId());
        $user = next($pageResult['list']);
        $this->assertEquals(self::$demoUser['id'], $user->getId());
    }
    public function testFindSortASC() {
        $page = array(
            'limit' => 50,
            'page' => 1,
            'sort' => array(
                array(
                    'property' => 'UserId',
                    'direction' => 'ASC'
                )
            ),
            'start' => 0
        );
        $pageResult = $this->userDao->find($page);
        $user = current($pageResult['list']);
        $this->assertEquals(self::$demoUser['id'], $user->getId());
        $user = next($pageResult['list']);
        $this->assertEquals(self::$demoUser2['id'], $user->getId());
    }
    /**
     * @expectedException \PHPX\Propel\Util\Ext\RuntimeException
     * @expectedExceptionMessage
     */
    public function testFindSortIllegalType() {
        $page = array(
            'limit' => 50,
            'page' => 1,
            'sort' => array(
                array(
                    'property' => 'UserId',
                    'direction' => 'Illegal'
                )
            ),
            'start' => 0
        );
        $this->userDao->find($page);
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
}
 