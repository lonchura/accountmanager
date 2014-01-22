<?php
/**
 * @author      psyduck.mans
 * @createTime  2014-01-12 22:14
 */
namespace Domain\Application\Dao\Impl;

use Domain\Application\Dao\Exception\AccountNotFoundException,
    Domain\Application\Po\Account,
    Domain\Application\Dao\RuntimeException;
use Propel\AccountQuery,
    Propel\Account as ORMAccount;
use PropelException;

/**
 * Class AccountDao
 * @package Domain\Application\Dao\Impl
 */
class AccountDao implements \Domain\Application\Dao\AccountDao {

    /**
     * find account by id
     *
     * @param $id
     * @throws \Domain\Application\Dao\Exception\AccountNotFoundException
     * @throws \Domain\Application\Dao\RuntimeException
     * @return Account|null
     */
    public function findAccountById($id)
    {
        $account = null;

        try {
            $ormAccount = AccountQuery::create()->findOneById($id);
            if($ormAccount) {
                $account = $this->convertAccountFrom($ormAccount);
            } else {
                throw new AccountNotFoundException("search by id:{$id}");
            }
        } catch(PropelException $e) {
            throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
        }

        return $account;
    }

    /**
     * save account
     *
     * @param Account $account
     * @throws \Domain\Application\Dao\RuntimeException
     * @return void
     */
    public function save(Account $account)
    {
        try {
            $ormAccount = $this->convertORMAccountFrom($account);
            $ormAccount->save();
        } catch(PropelException $e) {
            throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * update account
     *
     * @param Account $account
     * @throws \Domain\Application\Dao\RuntimeException
     * @return void
     */
    public function update(Account $account)
    {
        try {
            $account = $this->findAccountById($account->getId());
            $account->setUpdateTime(new \DateTime());
            $ormAccount = $this->convertORMAccountFrom($account);
            $ormAccount->save();
        } catch(PropelException $e) {
            throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * delete account
     *
     * @param Account $account
     * @throws \Domain\Application\Dao\RuntimeException
     * @return void
     */
    public function delete(Account $account)
    {
        try {
            $account = $this->findAccountById($account->getId());
            $ormAccount = $this->convertORMAccountFrom($account);
            $ormAccount->delete();
        } catch(PropelException $e) {
            throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * ORMAccount convert to Account
     *
     * @param ORMAccount $ormAccount
     * @return Account
     */
    private function convertAccountFrom(ORMAccount $ormAccount)
    {
        $account = new Account();
        $account->setId($ormAccount->getId());
        $account->setIdentifier($ormAccount->getIdentifier());
        $account->setPassword($ormAccount->getPassword());
        $account->setCreateTime($ormAccount->getCreateTime());
        $account->setUpdateTime($ormAccount->getUpdateTime());
        return $account;
    }

    /**
     * Account convert to Account
     *
     * @param Account $account
     * @return ORMAccount
     */
    private function convertORMAccountFrom(Account $account) {
        $ormAccount = new ORMAccount();
        $ormAccount->setId($account->getId())
                   ->setIdentifier($account->getIdentifier())
                   ->setPassword($account->getPassword())
                   ->setCreateTime($account->getCreateTime())
                   ->setUpdateTime($account->getUpdateTime());
        return $ormAccount;
    }
}