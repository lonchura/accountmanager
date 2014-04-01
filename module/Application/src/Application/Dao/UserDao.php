<?php
/**
 * Author: Psyduck.Mans
 */
namespace Application\Dao;
use Propel\User;

/**
 * Interface UserDao
 * @package Application\Dao
 */
interface UserDao {
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

    /**
     * @param User $user
     * @return int
     * @throws \Application\Dao\RuntimeException
     */
    public function save(User $user);
} 