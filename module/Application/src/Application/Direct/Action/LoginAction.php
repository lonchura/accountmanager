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

use Application\Auth\Adapter;
use Application\Service\CaptchaService;
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
        $cryptGenerator = $this->getServiceManager()->get('Accountmanager\Auth\Crypt');
        $adapter = new Adapter($cryptGenerator, $username, $password);
        $authenticationService = new AuthenticationService();
        $result = $authenticationService->authenticate($adapter);
        if($result->isValid()) {
            return new Success(array('identity' => $result->getIdentity()), '登陆成功');
        } else {
            return new Failure('登陆失败, '.current($result->getMessages()));
        }
    }

    /**
     * generate vcode
     *
     * @return Success
     */
    public function vcodeMethod() {
        $captcha = $this->getServiceManager()->get('Accountmanager\Service\Captcha');
        $captcha->generate();
        return new Success(array(
            'id' => $captcha->getId(),
            'imgSrc' => CaptchaService::$IMG_PATH.'/'.$captcha->getId().'.png'
        ));
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