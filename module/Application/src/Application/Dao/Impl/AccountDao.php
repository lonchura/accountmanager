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

use Propel\Account;
use Propel\AccountPeer;
use Propel\AccountQuery;

/**
 * Class AccountDao
 * @package Application\Dao\Impl
 */
class AccountDao implements \Application\Dao\AccountDao {
    /**
     * @var \Application\Auth\Identity
     */
    private $identity;

    /**
     * @param \Application\Auth\Identity $identity
     */
    public function __construct(\Application\Auth\Identity $identity) {
        $this->identity = $identity;
    }

    /**
     * @param $identifier
     * @return \Propel\Account|null
     */
    public function findOneByIdentifier($identifier) {
        return AccountQuery::create()->filterByUserId($this->identity->getId())->findOneByIdentifier($identifier);
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
        return array(
            'total' => AccountQuery::create()->filterByUserId($this->identity->getId())->count(),
            'list' => AccountQuery::create(null, $criteria)->filterByUserId($this->identity->getId())
                    ->setOffset($page['start'])
                    ->setLimit($page['limit'])
                    ->find()
        );
    }

    /**
     * @param $keyword
     * @param array $page Ext direct page request
     * @return array(
     *      'total' => int
     *      'list' => \PropelObjectCollection
     * )
     */
    public function findByIdentifierKeyword($keyword, array $page) {
        $criteria = new \Criteria();
        $criteria->addAnd(AccountPeer::IDENTIFIER, $keyword, \Criteria::LIKE);
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
        return array(
            'total' => AccountQuery::create(null, $criteria)->filterByUserId($this->identity->getId())->count(),
            'list' => AccountQuery::create(null, $criteria)->filterByUserId($this->identity->getId())
                    ->setLimit($page['limit'])
                    ->setOffset($page['start'])
                    ->find()
        );
    }

    /**
     * @param $id
     * @return \Propel\Account
     */
    public function getAccountById($id) {
        return AccountQuery::create()->filterByUserId($this->identity->getId())->findOneById($id);
    }

    /**
     * @param Account $account
     * @return int
     * @throws \Application\Dao\RuntimeException
     */
    public function save(Account $account) {
        try {
            $account->setUserId($this->identity->getId());
            $rowsAffected = $account->save();
        } catch(\Exception $e) {
            // TODO log
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
        return AccountQuery::create(null, $criteria)->filterByUserId($this->identity->getId())->delete();
    }
}