<?php
/**
 * @author      psyduck.mans
 * @createTime  2014-01-18 14:15
 */
namespace Domain\Application\Dao\Impl;

require_once 'Domain/Application/Dao/InitDaoTest.php';

use Domain\Application\Dao\InitDaoTest;

/**
 * Class AccountDaoTest
 * @property AccountDao accountDao
 * @package Domain\Application\Dao\Impl
 */
class AccountDaoTest extends InitDaoTest {
    /**
     * @var \Domain\Application\Dao\AccountDao
     */
    private $accountDao;

    protected function setUp()
    {
        parent::setUp();
        $this->accountDao = new AccountDao();
    }

    /**
     * @expectedException \Domain\Application\Dao\Exception\AccountNotFoundException
     * @expectedExceptionMessage
     */
    public function testFindAccountByIdThrowsAccountNotFoundException() {
        $this->accountDao->findAccountById(9);
    }

    public function testFindAccountById() {
        try {
            $account = $this->accountDao->findAccountById(999);
            $this->assertNotNull($account, 'Expect return not null');
            $this->assertInstanceOf('\Domain\Application\Po\Account', $account, 'Is not instance of \Domain\Application\Po\Account');
            $this->assertEquals('test Identifier', $account->getIdentifier(), 'Unexpected identifier');
            $this->assertEquals('123asd', $account->getPassword(), 'Unexpected password');
            $this->assertNotNull($account->getCreateTime(), 'CreateTime null given');
            $this->assertNotNull($account->getUpdateTime(), 'UpdateTime null given');
        } catch(\Domain\Application\Dao\Exception\AccountNotFoundException $e) {
            $this->assertFalse(true, 'Can not be here!');
        }
    }

    protected function tearDown()
    {
        $this->accountDao = null;
        parent::tearDown();
    }
}