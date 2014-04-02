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

use Propel\Account;

/**
 * Class AccountDaoTest
 * @package ApplicationTest\Dao\Impl
 */
class AccountDaoTest extends InitDaoTest {

    /**
     * @var \Application\Dao\AccountDao
     */
    private $accountDao;

    /**
     * setUp
     */
    protected function setUp()
    {
        parent::setUp();
        $this->accountDao = new \Application\Dao\Impl\AccountDao(self::$demoUser['id']);
    }
    /**
     * tearDown
     */
    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testFindOneByIdentifier() {
        $account = $this->accountDao->findOneByIdentifier(self::$demoAccount['identifier']);
        $this->assertNotNull($account, 'Expect return not null');
        $this->assertInstanceOf('\Propel\Account', $account, 'Is not instance of \Propel\Account');
        $this->assertEquals(self::$demoAccount['identifier'], $account->getIdentifier(), 'identifier unmatched');
        $this->assertEquals(self::$demoAccount['password'], $account->getPassword(), 'password unmatched');
    }
    public function testFindOneByNotFoundIdentifier() {
        $account = $this->accountDao->findOneByIdentifier('NotFoundIdentifier');
        $this->assertNull($account, 'Expect return null');
    }

    public function testFindNormal() {
        $page = array(
            'limit' => 50,
            'page' => 1,
            'sort' => null,
            'start' => 0
        );
        $pageResult = $this->accountDao->find($page);
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
                    'property' => 'Id',
                    'direction' => 'DESC'
                )
            ),
            'start' => 0
        );
        $pageResult = $this->accountDao->find($page);
        $account = current($pageResult['list']);
        $this->assertEquals(self::$demoAccount2['id'], $account->getId());
        $account = next($pageResult['list']);
        $this->assertEquals(self::$demoAccount['id'], $account->getId());
    }
    public function testFindSortASC() {
        $page = array(
            'limit' => 50,
            'page' => 1,
            'sort' => array(
                array(
                    'property' => 'Id',
                    'direction' => 'ASC'
                )
            ),
            'start' => 0
        );
        $pageResult = $this->accountDao->find($page);
        $account = current($pageResult['list']);
        $this->assertEquals(self::$demoAccount['id'], $account->getId());
        $account = next($pageResult['list']);
        $this->assertEquals(self::$demoAccount2['id'], $account->getId());
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
                    'property' => 'Id',
                    'direction' => 'Illegal'
                )
            ),
            'start' => 0
        );
        $this->accountDao->find($page);
    }

    public function testGetAccountById() {
        $account = $this->accountDao->getAccountById(self::$demoAccount['id']);

        $this->assertNotNull($account, 'Expect return not null');
        $this->assertInstanceOf('\Propel\Account', $account, 'Is not instance of \Propel\Account');
        $this->assertEquals(self::$demoAccount['identifier'], $account->getIdentifier(), 'identifier unmatched');
        $this->assertEquals(self::$demoAccount['password'], $account->getPassword(), 'password unmatched');
    }
    public function testGetAccountByNotFoundId() {
        $account = $this->accountDao->getAccountById(100);
        $this->assertNull($account, 'Expect return null');
    }

    public function testSave() {
        $expectAccount = array(
            'identifier' => 'ninth.not-bad.org',
            'password' => 'IOH*(F#@(ad21=-'
        );

        $account = new Account();
        $account->setUserId(self::$demoUser['id']);
        $account->setIdentifier($expectAccount['identifier']);
        $account->setPassword($expectAccount['password']);

        $rowsAffected = $this->accountDao->save($account);
        $this->assertEquals(1, $rowsAffected);
    }
    /**
     * @expectedException \Application\Dao\RuntimeException
     * @expectedExceptionMessage
     */
    public function testSaveException() {
        $account = new Account();
        $account->setUserId(self::$demoUser['id']);
        $account->setIdentifier(self::$demoAccount['identifier']);
        $account->setPassword('');

        $rowsAffected = $this->accountDao->save($account);
    }

    public function testDeleteRangeByIds() {
        $expectedRowsAffected = 2;
        $rowsAffected = $this->accountDao->deleteRangeByIds(array(
            self::$demoAccount['id'],
            self::$demoAccount2['id']
        ));
        $this->assertEquals($expectedRowsAffected, $rowsAffected, 'rows affected('.$rowsAffected.') not '.$expectedRowsAffected);
    }
    public function testDeleteRangeByNotFoundIds() {
        $expectedRowsAffected = 0;
        $rowsAffected = $this->accountDao->deleteRangeByIds(array(100));
        $this->assertEquals($expectedRowsAffected, $rowsAffected, 'rows affected('.$rowsAffected.') not '.$expectedRowsAffected);
    }
}
 