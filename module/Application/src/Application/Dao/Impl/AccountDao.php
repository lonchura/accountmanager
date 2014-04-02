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

use Domain\Application\Dao\Exception;
use Propel\Account;
use Propel\AccountPeer;
use Propel\AccountQuery;

/**
 * Class AccountDao
 * @package Application\Dao\Impl
 */
class AccountDao implements \Application\Dao\AccountDao {
    /**
     * @var
     */
    private $userId;

    /**
     * @param $userId
     */
    public function __construct($userId) {
        $this->userId = $userId;
    }

    /**
     * @param $identifier
     * @return \Propel\Account|null
     */
    public function findOneByIdentifier($identifier) {
        return AccountQuery::create()->filterByUserId($this->userId)->findOneByIdentifier($identifier);
    }

    /**
     * @param array $page Ext direct page request
     * @return array(
     *      'total' => int
     *      'list' => \PropelObjectCollection
     * )
     */
    public function find(array $page) {
        $criteria = new \Criteria();
        if(isset($page['sort']) && is_array($page['sort'])) {
            foreach($page['sort'] as $sort) {
                \PHPX\Propel\Util\Ext\Direct\Criteria::bindSort(
                    $criteria,
                    array_merge($sort, array(
                        'column' => AccountPeer::$modelFieldMapping[$sort['property']]
                    )
                ));
            }
        }
        $criteria->setOffset($page['start']);
        $criteria->setLimit($page['limit']);
        return array(
            'total' => AccountQuery::create()->filterByUserId($this->userId)->count(),
            'list' => AccountQuery::create(null, $criteria)->filterByUserId($this->userId)->find()
        );
    }

    /**
     * @param $id
     * @return \Propel\Account
     */
    public function getAccountById($id) {
        return AccountQuery::create()->filterByUserId($this->userId)->findOneById($id);
    }

    /**
     * @param Account $account
     * @return int
     * @throws \Application\Dao\RuntimeException
     */
    public function save(Account $account) {
        try {
            $rowsAffected = $account->save();
        } catch(\Exception $e) {
            throw new \Application\Dao\RuntimeException('save($account) failed', 0, $e);
        }
        return $rowsAffected;
    }

    /**
     * @param array $ids
     * @return int
     */
    public function deleteRangeByIds(array $ids) {
        $criteria = new \Criteria();
        $criteria->addAnd(AccountPeer::ID, $ids, \Criteria::IN);
        return AccountQuery::create(null, $criteria)->filterByUserId($this->userId)->delete();
    }
}