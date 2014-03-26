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
} 