<?php
/**
 * Account Manager System (https://github.com/PsyduckMans/resourcemanager)
 *
 * @link      https://github.com/PsyduckMans/resourcemanager for the canonical source repository
 * @copyright Copyright (c) 2014 PsyduckMans (https://ninth.not-bad.org)
 * @license   https://github.com/PsyduckMans/resourcemanager/blob/master/LICENSE MIT
 * @author    Psyduck.Mans
 */

namespace Application\Direct\Action;

use PHPX\Ext\Direct\Result\Failure;
use PHPX\Ext\Direct\Result\Success;
use PHPX\Proxy\DynamicProxy;
use Propel\Resource;

/**
 * Class ResourceAction
 * @package Application\Direct\Action
 */
class ResourceAction extends BaseAction {
    /**
     * @var DynamicProxy<\Application\Dao\Impl\ResourceDao>
     */
    private $resourceDao;
    /**
     * @return DynamicProxy
     */
    public function loadResourceDao() {
        if(!$this->resourceDao) {
            $identity = $this->getServiceManager()->get('Accountmanager\Auth\AuthenticationService')->getIdentity();
            $this->resourceDao = DynamicProxy::createFrom(new \Application\Dao\Impl\ResourceDao($identity));
        }
        return $this->resourceDao;
    }

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
        if(!isset($page['CategoryId'])) {
            return new Failure('未选择分类');
        }
        $categoryId = $page['CategoryId'];
        $rows = array();

        $result = $this->loadResourceDao()->findByCategoryId($categoryId, $page);
        foreach($result['list'] as $resource) {
            array_push($rows, array(
                'Id' => $resource->getId(),
                'Name' => $resource->getName(),
                'Description' => $resource->getDescription(),
                'CreateTime' => $resource->getCreateTime(),
                'UpdateTime' => $resource->getUpdateTime()
            ));
        }

        return new Success(array(
            'total' => $result['total'],
            'data' => $rows
        ), '');
    }

    public function addMethod(array $data) {
        $resource = new Resource();
        $resource->setCategoryId($data['CategoryId']);
        $resource->setName($data['Name']);
        $resource->setDescription($data['Description']);

        $this->loadResourceDao()->save($resource);
        return new Success(array('data' => array(
            'Id' => $resource->getId(),
            'Name' => $resource->getName(),
            'Description' => $resource->getDescription(),
            'CreateTime' => $resource->getCreateTime(),
            'UpdateTime' => $resource->getUpdateTime()
        )), '添加成功');
    }

    public function editMethod(array $data) {
        $resource = $this->loadResourceDao()->findOneById($data['Id']);
        $resource->setName($data['Name']);
        $resource->setDescription($data['Description']);

        $this->loadResourceDao()->save($resource);
        return new Success(array('data' => array(
            'Id' => $resource->getId(),
            'Name' => $resource->getName(),
            'Description' => $resource->getDescription(),
            'CreateTime' => $resource->getCreateTime(),
            'UpdateTime' => $resource->getUpdateTime()
        )), '修改成功');
    }

    public function deleteMethod(array $data) {
        $ids = $data[0];
        $this->loadResourceDao()->deleteRangeByIds($ids);
        return new Success($ids, '删除成功');
    }

    public function accountListMethod(array $data) {
        $page = $data[0];
        if(!isset($page['ResourceId'])) {
            return new Failure('未选择资源');
        }
        $resourceId = $page['ResourceId'];
        $rows = array();

        $result = $this->loadResourceDao()->findAccountsByResourceId($resourceId, $page);
        foreach($result['list'] as $resourceAccount) {
            array_push($rows, array(
                'ResourceId' => $resourceAccount->getResourceId(),
                'AccountId' => $resourceAccount->getAccountId(),
                'Identifier' => $resourceAccount->getAccount()->getIdentifier(),
                'Password' => $resourceAccount->getAccount()->getPassword(),
                'CreateTime' => $resourceAccount->getCreateTime(),
            ));
        }

        return new Success(array(
            'total' => $result['total'],
            'data' => $rows
        ), '');
    }

    public function accountAssociateMethod(array $data) {
        $resourceId = $data['ResourceId'];
        $accountId = $data['AccountId'];
        $resource = $this->loadResourceDao()->findOneById($resourceId);
        $account = $this->loadAccountDao()->getAccountById($accountId);

        if(!$account) {
            return new Failure('请选择关联账号');
        }
        if(!$this->loadResourceDao()->isAssociatedAccount($resourceId, $accountId)) {
            $resource->addAccount($account);
            $this->loadResourceDao()->save($resource);
            return new Success(array('data' => array(
                'ResourceId' => $resource->getId(),
                'AccountId' => $account->getId(),
                'Identifier' => $account->getIdentifier(),
                'Password' => $account->getPassword(),
                'CreateTime' => date('Y-m-d H:i:s')
            )), '关联成功');
        } else {
            return new Failure('该'.$account->getIdentifier().'账号已在关联列表中');
        }
    }

    public function accountDeleteMethod(array $data) {
        $dels = $data[0];
        $resourceId = $dels['ResourceId'];
        $accountIds = $dels['AccountIds'];

        $this->loadResourceDao()->deleteRangeByAssociateAccountIds($resourceId, $accountIds);
        return new Success($accountIds, '删除成功');
    }
} 