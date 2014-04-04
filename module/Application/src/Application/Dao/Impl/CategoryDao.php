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

use Propel\Category;
use Propel\CategoryPeer;
use Propel\CategoryQuery;

/**
 * Class CategoryDao
 * @package Application\Dao\Impl
 */
class CategoryDao implements \Application\Dao\CategoryDao {
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
     * @param $id
     * @return Category
     */
    public function findOneById($id) {
        return CategoryQuery::create()->findOneById($id);
    }

    /**
     * @param $pid
     * @return \PropelObjectCollection
     */
    public function findByParentId($pid)
    {
        return CategoryQuery::create()->filterByUserId($this->identity->getId())->findByPid($pid);
    }

    /**
     * @transaction
     * @param Category $category
     * @return int
     * @throws \Application\Dao\RuntimeException
     */
    public function save(Category $category)
    {
        $rowsAffected = 0;
        $conn = \Propel::getConnection();
        $conn->beginTransaction();
        try {
            $category->setUserId($this->identity->getId());
            $rowsAffected = $category->save();
            $pCategory = CategoryQuery::create()->findOneById($category->getPid());
            $pCategory->setChildCount($pCategory->getChildCount()+1);
            $rowsAffected += $pCategory->save();
            $conn->commit();
        } catch(\Exception $e) {
            // TODO log->($e)
            $conn->rollBack();
        }
        return $rowsAffected;
    }

    /**
     * @param Category $category
     * @return int
     */
    public function update(Category $category) {
        $category->setUserId($this->identity->getId());
        $rowsAffected = $category->save();
        return $rowsAffected;
    }

    /**
     * @param array $ids
     * @return int
     */
    public function deleteRangeByIds(array $ids) {
        $criteria = new \Criteria();
        $criteria->addAnd(CategoryPeer::ID, $ids, \Criteria::IN);
        return CategoryQuery::create(null, $criteria)->filterByUserId($this->identity->getId())->delete();
    }

    /**
     * @param $id
     */
    public function deleteById($id) {
        $conn = \Propel::getConnection();
        $conn->beginTransaction();
        try {
            $category = CategoryQuery::create()->findOneById($id);
            $pid = $category->getPid();
            $category->delete();
            $pCategory = CategoryQuery::create()->findOneById($pid);
            $pCategory->setChildCount($pCategory->getChildCount()-1);
            $pCategory->save();
            $conn->commit();
        } catch(\Exception $e) {
            // TODO log->($e)
            $conn->rollBack();
        }
    }
}