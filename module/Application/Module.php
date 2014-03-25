<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;

class Module implements ServiceProviderInterface
{
   public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $this->bootstrapSession($e);
    }

    public function bootstrapSession(MvcEvent $e)
    {
        $session = $e->getApplication()->getServiceManager()->get('Zend\Session\SessionManager');

        $container = new Container('initialized');
        if (!isset($container->init) || true) {
            $session->regenerateId(true);
            $container->init = 1;
        }
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig()
    {
        return require __DIR__ . '/config/services.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    /* module load */
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                    /* common load */
                    'PHPX' => APPLICATION_LIBRARY.'/PHPX',
                    'Domain' => APPLICATION_LIBRARY.'/Domain'
                ),
            ),
        );
    }
}
