<?php
/**
 * Author: Psyduck.Mans
 */
namespace Application\Dao;

/**
 * Interface UserDao
 * @package Application\Dao
 */
interface UserDao {
    /**
     * find User by where
     *
     * @param array $where
     * @return \Propel\User
     */
    public function findOneByWhere(array $where);

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
     * @return \Propel\User
     */
    public function getUserById($id);

    /**
     * @param array $ids
     * @return int
     */
    public function deleteRangeByIds(array $ids);
} 