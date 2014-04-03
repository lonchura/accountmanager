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
use PHPX\Ext\Direct\Result\Failure;
use PHPX\Ext\Direct\Result\Success;
use PHPX\Proxy\DynamicProxy;
use Propel\Account;
use Zend\ServiceManager\ServiceManager;

/**
 * Class AccountAction
 * @package Application\Direct\Action
 */
class AccountAction extends BaseAction {
    /**
     * @var DynamicProxy<\Application\Dao\Impl\AccountDao>
     */
    private $accountDao;

    /**
     * @return DynamicProxy
     */
    public function loadAccountDao() {
        if(!$this->accountDao) {
            $identity = $this->getServiceManager()->get('Accountmanager\Auth\AuthenticationService')->getIdentity();
            $this->accountDao = DynamicProxy::createFrom(new \Application\Dao\Impl\AccountDao($identity));
        }
        return $this->accountDao;
    }

    public function listMethod(array $data) {
        $page = $data[0];
        $rows = array();

        $result = $this->loadAccountDao()->find($page);
        foreach($result['list'] as $account) {
            array_push($rows, array(
                'Id' => $account->getId(),
                'Identifier' => $account->getIdentifier(),
                'CreateTime' => $account->getCreateTime(),
                'UpdateTime' => $account->getUpdateTime()
            ));
        }

        return new Success(array(
            'total' => $result['total'],
            'data' => $rows
        ), '');
    }

    public function addMethod(array $data) {
        // check dupli name
        $account = $this->loadAccountDao()->findOneByIdentifier($data['Identifier']);
        if($account) {
            return new Failure('账号标识:“'.$data['Identifier'].'”已存在，请重新命名');
        }
        // add save
        $account = new Account();
        $account->setIdentifier($data['Identifier']);
        $account->setPassword($data['Password']);
        $this->loadAccountDao()->save($account);
        // success return
        return new Success(array(
            'Id' => $account->getId(),
            'Identifier' => $account->getIdentifier(),
            'Password' => $account->getPassword(),
            'CreateTime' => $account->getCreateTime(),
            'UpdateTime' => $account->getUpdateTime()
        ), '添加成功');
    }

    public function editMethod(array $data) {
        // check dupli name
        $account = $this->loadAccountDao()->findOneByIdentifier($data['Identifier']);
        if($account && $account->getId()!=$data['Id']) {
            return new Failure('账号标识:“'.$data['Identifier'].'”已存在，请重新命名');
        }
        // check current account
        $account = $this->loadAccountDao()->getAccountById($data['Id']);
        if(!$account) {
            return new Failure('用户:“'.$data['Id'].'”，未找到');
        }
        // edit save
        $account->setIdentifier($data['Identifier']);
        if(trim($data['Password'])) {
            $account->setPassword($data['Password']);
        }
        $this->loadAccountDao()->save($account);
        // success return
        return new Success(array(
            'Id' => $account->getId(),
            'Identifier' => $account->getIdentifier(),
            'Password' => $account->getPassword(),
            'CreateTime' => $account->getCreateTime(),
            'UpdateTime' => $account->getUpdateTime()
        ), '编辑成功');
    }

    public function deleteMethod(array $data) {
        $ids = $data[0];
        $this->loadAccountDao()->deleteRangeByIds($ids);
        return new Success($ids, '删除成功');
    }
}