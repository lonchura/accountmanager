<?php
/**
 * Author: Psyduck.Mans
 */

namespace Application\Controller;

use Zend\View\Model\JsonModel;

/**
 * Class DirectController
 * @package Application\Controller
 */
class DirectController extends BaseController {

    public function routerAction() {
        $protocal = \PHPX\Ext\Direct\ProtocalFactory::create(
            \PHPX\Ext\Direct\Util\ProtocalRawData::read()
        );

        $processHandler = \PHPX\Ext\Direct\ProcesseHandler::getInstance()
            ->setActionManager(new \PHPX\Ext\Direct\ActionManager(array(
                'actions' => array(
                    'AccountManager.Direct.Login' => function() {
                        return $this->getServiceLocator()->get('Accountmanager\Direct\Service\login');
                    },
                    'AccountManager.Direct.Resource' => function() {
                        return $this->getServiceLocator()->get('Accountmanager\Direct\Service\Resource');
                    },
                    'AccountManager.Direct.Category' => function() {
                        return $this->getServiceLocator()->get('Accountmanager\Direct\Service\Category');
                    },
                    'AccountManager.Direct.Account' => function() {
                        return $this->getServiceLocator()->get('Accountmanager\Direct\Service\Account');
                    },
                    'AccountManager.Direct.User' => function() {
                        return $this->getServiceLocator()->get('Accountmanager\Direct\Service\User');
                    },
                    'AccountManager.Direct.Role' => function() {
                        return $this->getServiceLocator()->get('Accountmanager\Direct\Service\Role');
                    },
                )
            )));
        $processHandler->execute($protocal);
        return new JsonModel($protocal->toArray());
    }

    public function apiAction() {
    }
} 