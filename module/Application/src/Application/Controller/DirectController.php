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
                    'AccountManager.Direct.Login' => $this->getServiceLocator()->get('Accountmanager\Direct\Service\login')
                )
            )));
        $processHandler->execute($protocal);
        return new JsonModel($protocal->toArray());
    }

    public function apiAction() {
    }
} 