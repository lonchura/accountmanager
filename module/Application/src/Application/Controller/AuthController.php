<?php
/**
 * Account Manager System (https://github.com/PsyduckMans/accountmanager)
 *
 * @link      https://github.com/PsyduckMans/accountmanager for the canonical source repository
 * @copyright Copyright (c) 2014 PsyduckMans (https://ninth.not-bad.org)
 * @license   https://github.com/PsyduckMans/accountmanager/blob/master/LICENSE MIT
 * @author    Psyduck.Mans
 */

namespace Application\Controller;


use Application\Auth\Adapter;
use Zend\Authentication\AuthenticationService;
use Zend\Mvc\MvcEvent;

class AuthController extends BaseController {
    /**
     * @var mix|null
     */
    private $identity;
    /**
     * @override
     * @see AbstractController::attachDefaultListeners
     */
    protected function attachDefaultListeners()
    {
        parent::attachDefaultListeners();
        $events = $this->getEventManager();
        $events->attach(MvcEvent::EVENT_DISPATCH, array($this, 'preDispatch'), 100);
    }

    /**
     * auth handle
     *
     * @param MvcEvent $e
     */
    public function preDispatch(\Zend\Mvc\MvcEvent $e) {
        $authenticationService = new AuthenticationService();
        if($authenticationService->getIdentity()) {
            $this->identity = $authenticationService->getIdentity();
        }
    }

    /**
     * @return bool
     */
    public function hasIdentity() {
        return null !== $this->identity;
    }

    /**
     * @return mix|null
     */
    public function getIdentity() {
        return $this->identity;
    }
}