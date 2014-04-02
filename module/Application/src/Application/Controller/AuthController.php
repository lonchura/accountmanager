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

use Zend\Mvc\MvcEvent;

/**
 * Class AuthController
 * @package Application\Controller
 */
class AuthController extends BaseController {
    /**
     * @var \Application\Auth\Identity
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
        $this->identity = $e->getApplication()->getServiceManager()->get('Accountmanager\Auth\AuthenticationService')->getIdentity();
    }

    /**
     * @return bool
     */
    protected function hasIdentity() {
        return null !== $this->identity;
    }

    /**
     * @return \Application\Auth\Identity
     */
    protected function getIdentity() {
        return $this->identity;
    }
}