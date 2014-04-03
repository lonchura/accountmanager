<?php
/**
 * Account Manager System (https://github.com/PsyduckMans/accountmanager)
 *
 * @link      https://github.com/PsyduckMans/accountmanager for the canonical source repository
 * @copyright Copyright (c) 2014 PsyduckMans (https://ninth.not-bad.org)
 * @license   https://github.com/PsyduckMans/accountmanager/blob/master/LICENSE MIT
 * @author    Psyduck.Mans
 */

namespace Application\Direct\Action;

use PHPX\Proxy\DynamicProxy;
use Zend\ServiceManager\ServiceManager;

/**
 * Class AuthAction
 * @package Application\Direct\Action
 */
class AuthProxyAction extends DynamicProxy {

    /**
     * @var \Zend\Authentication\AuthenticationService
     */
    private $authenticationService;

    /**
     * __construct
     *
     * @extend
     * @param ServiceManager $sm
     * @param BaseAction $action
     * @throws \PHPX\Ext\Direct\RuntimeException
     */
    public function __construct(ServiceManager $sm, BaseAction $action)
    {
        $this->authenticationService = $sm->get('Accountmanager\Auth\AuthenticationService');
        $this->target = $action;
    }

    /**
     * @override
     * @param $name
     * @param $arguments
     * @throws \RuntimeException
     */
    protected function __preCall($name, $arguments)
    {
        if(!$this->authenticationService->hasIdentity()) {
            throw new \PHPX\Ext\Direct\RuntimeException('无权限');
        }
    }
}