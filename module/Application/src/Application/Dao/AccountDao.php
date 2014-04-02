<?php
/**
 * Author: Psyduck.Mans
 */
namespace Application\Dao;
use Propel\Account;

/**
 * Interface AccountDao
 * @package Application\Dao
 */
interface AccountDao {
    /**
     * @param $identifier
     * @return \Propel\Account|null
     */
    public function findOneByIdentifier($identifier);

    /**
     * @param array $page
     * @return array(
     *      'total' => int
     *      'list' => \PropelObjectCollection
     * )
     */
    public function find(array $page);

    /**
     * @param $id
     * @return \Propel\Account
     */
    public function getAccountById($id);

    /**
     * @param array $ids
     * @return int
     */
    public function deleteRangeByIds(array $ids);

    /**
     * @param Account $account
     * @return int
     * @throws \Application\Dao\RuntimeException
     */
    public function save(Account $account);
} 