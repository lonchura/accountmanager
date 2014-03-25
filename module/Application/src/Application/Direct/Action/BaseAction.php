<?php
/**
 * Author: Psyduck.Mans
 */

namespace Application\Direct\Action;

use Zend\ServiceManager\ServiceManager;

class BaseAction {
    /**
     * @var ServiceManager
     */
    private $sm;

    /**
     * __construct
     *
     * @param ServiceManager $sm
     */
    public function __construct(ServiceManager $sm) {
        $this->sm = $sm;
    }

    /**
     * @return ServiceManager
     */
    public function getServiceManager() {
        return $this->sm;
    }
} 