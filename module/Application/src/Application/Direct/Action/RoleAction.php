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
use Propel\RoleQuery;

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
        $roles = array();
        foreach(RoleQuery::create()->find() as $role) {
            array_push($roles, array(
                'RoleId' => $role->getId(), 'RoleName' => $role->getName()
            ));
        }
        return new Success(array('data' => $roles), '');
    }
} 