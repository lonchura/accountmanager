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

/**
 * Class Identity
 * @package Application\Auth
 */
class Identity {
    /**
     * @var \Propel\User
     */
    private $user;

    /**
     * @param User $user
     */
    public function __construct(User $user) {
        $this->user = $user;
    }

    /**
     * @param User $user
     * @return Identity
     */
    public static function createFrom(User $user) {
        return new self($user);
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->user->getId();
    }

    /**
     * @return int
     */
    public function getRoleId() {
        return $this->user->getRoleId();
    }

    /**
     * @return string
     */
    public function getNickname() {
        return $this->user->getNickname();
    }

    public function toArray() {
        return array(
            'id' => $this->getId(),
            'role_id' => $this->getRoleId(),
            'nickname' => $this->getNickname()
        );
    }
}