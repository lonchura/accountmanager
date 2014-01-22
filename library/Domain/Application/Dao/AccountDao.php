<?php
/**
 * @author      psyduck.mans
 * @createTime  2014-01-12 22:01
 */

namespace Domain\Application\Dao;

use Domain\Application\Po\Account;

/**
 * Interface AccountDao
 * @package Domain\Application\Dao
 */
interface AccountDao {
    /**
     * find account by id
     *
     * @param $id
     * @return Account
     */
    public function findAccountById($id);

    /**
     * save account
     *
     * @param Account $account
     * @return void
     */
    public function save(Account $account);

    /**
     * update account
     *
     * @param Account $account
     * @return void
     */
    public function update(Account $account);

    /**
     * delete account
     *
     * @param Account $account
     * @return void
     */
    public function delete(Account $account);
} 