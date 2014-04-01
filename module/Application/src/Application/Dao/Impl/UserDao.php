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
use Propel\User;
use Propel\UserPeer;
use Propel\UserQuery;

/**
 * Class UserDao
 * @package Application\Dao\Impl
 */
class UserDao implements \Application\Dao\UserDao {

    /**
     * @param $name
     * @return \Propel\User|null
     */
    public function findOneByName($name) {
        return UserQuery::create()->findOneByName($name);
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
                        'column' => UserPeer::$modelFieldMapping[$sort['property']]
                    )
                ));
            }
        }
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
     * @param User $user
     * @return int
     * @throws \Application\Dao\RuntimeException
     */
    public function save(User $user) {
        try {
            $rowsAffected = $user->save();
        } catch(\Exception $e) {
            throw new \Application\Dao\RuntimeException('save($user) failed', 0, $e);
        }
        return $rowsAffected;
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