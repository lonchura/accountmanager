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
use PHPX\Ext\Direct\Result\Success;

/**
 * Class RoleAction
 * @package Application\Direct\Action
 */
class RoleAction extends BaseAction {

    /**
     * @param array $data
     * @return Success
     */
    public function listMethod(array $data) {
        return new Success(array('data' => array(
            array('RoleId' => 1, 'RoleName'=>'管理员'),
            array('RoleId' => 2, 'RoleName'=>'普通用户')
        )), '');
    }
} 