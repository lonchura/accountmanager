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

    public function listMethod(array $data) {
        $page = $data[0];
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
} 