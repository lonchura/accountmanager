<?php
/**
 * Author: Psyduck.Mans
 */

namespace Application\Direct\Action;

use Application\Auth\Adapter;
use PHPX\Ext\Direct\Result\Failure;
use PHPX\Ext\Direct\Result\Success;
use Zend\Authentication\AuthenticationService;

/**
 * Class LoginAction
 * @package Application\Direct\Action
 */
class LoginAction extends BaseAction {
    /**
     * @param array $data
     * @return Success
     * @throws \Exception
     */
    public function checkMethod(array $data) {
        $vcodeId = $data['vcodeId'];
        $vcode = $data['vcode'];
        $username = $data['username'];
        $password = $data['password'];

        // check captcha
        $captcha = $this->getServiceManager()->get('Accountmanager\Service\Captcha');
        if(!$captcha->isVaild($vcodeId, $vcode)) {
            throw new \Exception(current($captcha->getMessages()));
        }

        // check auth
        $adapter = new Adapter($username, $password);
        $authenticationService = new AuthenticationService();
        $result = $authenticationService->authenticate($adapter);
        if($result->isValid()) {
            return new Success(array('identity' => $result->getIdentity()), '登陆成功');
        } else {
            return new Failure('登陆失败, '.current($result->getMessages()));
        }
    }

    /**
     * @param array $data
     * @return Success
     */
    public function quitMethod(array $data) {
        $session = $this->getServiceManager()->get('Zend\Session\SessionManager');
        $session->destroy();
        return new Success(array(), '退出成功');
    }
}