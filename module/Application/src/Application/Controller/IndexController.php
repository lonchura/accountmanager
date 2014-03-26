<?php
/**
 * Created by Psyduck.Mans
 */

namespace Application\Controller;

use Zend\View\Model\ViewModel;

class IndexController extends AuthController
{
    public function indexAction()
    {
        return new ViewModel(array(
            'hasIdentity' => $this->hasIdentity()
        ));
    }
}