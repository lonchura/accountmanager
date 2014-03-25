<?php
/**
 * Author: Psyduck.Mans
 */

namespace Application\Direct\Action;

use PHPX\Ext\Direct\Result\Success;

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

        $captcha = $this->getServiceManager()->get('Accountmanager\Service\Captcha');
        if(!$captcha->isVaild($vcodeId, $vcode)) {
            throw new \Exception(current($captcha->getMessages()));
        }

        setcookie('hasLogin', 'true', time()+3600, '/', 'accountmanager.t.com');
        return new Success(
            array('userInfo' => array(
                'role' => '用户'
            )),
            '登陆成功'
        );
    }

    /**
     * @param array $data
     * @return Success
     */
    public function quitMethod(array $data) {
        setcookie('hasLogin', 'true', time()-3600, '/', 'accountmanager.t.com');
        return new Success(array(), '退出成功');
    }
}