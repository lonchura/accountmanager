<?php
/**
 * Author: Psyduck.Mans
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

/**
 * Class BaseController
 * @package Application\Controller
 */
class BaseController extends AbstractActionController {
    /**
     * @return \Zend\Session\SessionManager
     */
    protected function getSessionManager() {
        $sessionManager = $this->getServiceLocator()->get('Zend\Session\SessionManager');
        return $sessionManager;
    }
} 