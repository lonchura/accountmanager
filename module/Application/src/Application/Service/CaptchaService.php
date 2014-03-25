<?php
/**
 * Author: Psyduck.Mans
 */

namespace Application\Service;

/**
 * Class CaptchaService
 * @package Application\Service
 */
class CaptchaService {
    /**
     * @var \Zend\Captcha\Image
     */
    private $captcha;

    /**
     * @var
     */
    public static $IMG_PATH = '/captcha';

    /**
     * @param array $config
     */
    public function __construct(array $config) {
        $this->captcha = new \Zend\Captcha\Image($config);
        $this->captcha->setMessage('验证码错误', \Zend\Captcha\Image::BAD_CAPTCHA);
    }

    /**
     * captcha image generate
     */
    public function generate() {
        $this->captcha->generate();
    }

    /**
     * @return string
     */
    public function getId() {
        return $this->captcha->getId();
    }

    /**
     * @param $id
     * @param $value
     * @return bool
     */
    public function isVaild($id, $value) {
        return $this->captcha->isValid($value, array(
            'id' => $id,
            'input' => $value
        ));
    }

    /**
     * @return array
     */
    public function getMessages() {
        return $this->captcha->getMessages();
    }
}