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

/**
 * Class Crypt
 * @package Application\Auth
 */
class Crypt {

    /**
     * @var \Zend\Crypt\Password\PasswordInterface
     */
    private $passwordGenerator;

    /**
     * @param array $options
     */
    public function __construct(array $options) {
        $this->passwordBuilder = new \Zend\Crypt\Password\Bcrypt($options);
    }

    /**
     * @param $password
     * @return string
     */
    public function create($password) {
        return $this->passwordBuilder->create($password);
    }

    /**
     * @param string $password
     * @param string $hash
     * @return bool
     */
    public function verify($password, $hash) {
        return $this->passwordBuilder->verify($password, $hash);
    }
} 