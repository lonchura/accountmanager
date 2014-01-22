<?php
/**
 * @author      psyduck.mans
 * @createTime  2014-01-18 16:17
 */
namespace Domain\Application\Dao;
use Propel\Account;

/**
 * Class Test
 * @package Domain\Application\Dao
 */
class InitDaoTest extends \PHPUnit_Framework_TestCase {
    protected function setUp()
    {
        parent::setUp();
        $this->initAccount();
    }

    protected function tearDown()
    {
        $this->dropAccount();
        parent::tearDown();
    }

    private function initAccount()
    {
        $conn = \Propel::getConnection();
        $conn->beginTransaction();
        try {
            $sql = sprintf("INSERT INTO account(id, identifier, password, create_time, update_time) VALUES('%d', '%s', '%s', '%s', '%s');",
                999,
                'test Identifier',
                '123asd',
                date('Y-m-d H:i:s'),
                date('Y-m-d H:i:s')
            );
            $ret = $conn->exec($sql);
            $conn->commit();
        } catch(\Exception $e) {
            if($conn->inTransaction()) {
                $conn->rollBack();
            }
            $this->assertFalse(true, $e->getMessage());
        }
    }

    private function dropAccount()
    {
        $conn = \Propel::getConnection();
        $conn->beginTransaction();
        try {
            $conn->exec('DELETE FROM account_manager.account');
            $conn->commit();
        } catch(\Exception $e) {
            if($conn->inTransaction()) {
                $conn->rollBack();
            }
            $this->assertFalse(true, $e->getMessage());
        }
    }
}
 