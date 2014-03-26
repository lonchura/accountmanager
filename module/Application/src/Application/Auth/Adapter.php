<?php
/**
 * Account Manager System (https://github.com/PsyduckMans/accountmanager)
 *
 * @link      https://github.com/PsyduckMans/accountmanager for the canonical source repository
 * @copyright Copyright (c) 2014 PsyduckMans (https://ninth.not-bad.org)
 * @license   https://github.com/PsyduckMans/accountmanager/blob/master/LICENSE MIT
 * @author    Psyduck.Mans
 */

namespace Application\Auth;

use Propel\User;
use Propel\UserPeer;
use Zend\Authentication\Adapter\AdapterInterface;
use Application\Dao\Impl\UserDao;
use Zend\Authentication\Result;

/**
 * Class Adapter
 * @package Application\Auth
 */
class Adapter implements AdapterInterface {

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @param $usename
     * @param $password
     */
    public function __construct($usename, $password) {
        $this->username = $usename;
        $this->password = $password;
    }

    /**
     * Performs an authentication attempt
     *
     * @return \Zend\Authentication\Result
     * @throws \Zend\Authentication\Adapter\Exception\ExceptionInterface If authentication cannot be performed
     */
    public function authenticate() {
        $userDao = new UserDao();
        $user = $userDao->findOneByWhere(array(
            UserPeer::NAME => $this->username,
            UserPeer::PASSWORD => $this->password
        ));
        if($user instanceof User) {
            return new Result(Result::SUCCESS, $user->getIdentity(), array());
        } else {
            return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, array('用户名或密码不正确'));
        }
    }
}