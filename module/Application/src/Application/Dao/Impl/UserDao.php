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

use Propel\UserPeer;
use Propel\UserQuery;

/**
 * Class UserDao
 * @package Application\Dao\Impl
 */
class UserDao implements \Application\Dao\UserDao {

    /**
     * @param array $where
     * @return \Propel\User|null
     */
    public function findOneByWhere(array $where)
    {
        $criteria = new \Criteria();
        foreach($where as $field=>$value) {
            $criteria->addAnd($field, $value);
        }
        return UserQuery::create(null, $criteria)->findOne();
    }

    /**
     * @param array $page
     * @return array(
     *      'total' => int
     *      'list' => \PropelObjectCollection
     * )
     */
    public function find(array $page) {
        $criteria = new \Criteria();
        $criteria->setOffset($page['start']);
        $criteria->setLimit($page['limit']);
        return array(
            'total' => UserQuery::create()->count(),
            'list' => UserQuery::create(null, $criteria)->find()
        );
    }

    /**
     * @param $id
     * @return \Propel\User
     */
    public function getUserById($id) {
        return UserQuery::create()->findOneById($id);
    }

    /**
     * @param array $ids
     * @return int
     */
    public function deleteRangeByIds(array $ids) {
        $criteria = new \Criteria();
        $criteria->addAnd(UserPeer::ID, $ids, \Criteria::IN);
        return UserQuery::create(null, $criteria)->delete();
    }
}