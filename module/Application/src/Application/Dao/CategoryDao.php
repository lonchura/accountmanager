<?php
/**
 * Account Manager System (https://github.com/PsyduckMans/accountmanager)
 *
 * @link      https://github.com/PsyduckMans/accountmanager for the canonical source repository
 * @copyright Copyright (c) 2014 PsyduckMans (https://ninth.not-bad.org)
 * @license   https://github.com/PsyduckMans/accountmanager/blob/master/LICENSE MIT
 * @author    Psyduck.Mans
 */

namespace Application\Dao;

use Propel\Category;

/**
 * Interface CategoryDao
 * @package Application\Dao
 */
interface CategoryDao {
    /**
     * @param $id
     * @return \Propel\Category|null
     */
    //public function getCategoryById($id);

    /**
     * @param $pid
     * @return \PropelObjectCollection
     */
    public function findByParentId($pid);

    /**
     * @param Category $category
     * @return int
     * @throws \Application\Dao\RuntimeException
     */
    public function save(Category $category);

    /**
     * @param Category $category
     * @return int
     */
    public function update(Category $category);

    /**
     * @param array $ids
     * @return int
     */
    public function deleteRangeByIds(array $ids);

    /**
     * @param $id
     */
    public function deleteById($id);
}