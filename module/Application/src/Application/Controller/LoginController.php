<?php
/**
 * Author: Psyduck.Mans
 */

namespace Application\Controller;

use Application\Service\CaptchaService;
use Zend\Session\Container;
use Zend\View\Model\JsonModel;

/**
 * Class LoginController
 * @package Application\Controller
 */
class LoginController extends BaseController {

    public function vcodeAction() {
        $captcha = $this->getServiceLocator()->get('Accountmanager\Service\Captcha');
        $captcha->generate();

        return new JsonModel(array(
            'id' => $captcha->getId(),
            'imgSrc' => CaptchaService::$IMG_PATH.'/'.$captcha->getId().'.png'
        ));
    }
}