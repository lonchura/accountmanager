<?php
/**
 * Account Manager System (https://github.com/PsyduckMans/categorymanager)
 *
 * @link      https://github.com/PsyduckMans/categorymanager for the canonical source repository
 * @copyright Copyright (c) 2014 PsyduckMans (https://ninth.not-bad.org)
 * @license   https://github.com/PsyduckMans/categorymanager/blob/master/LICENSE MIT
 * @author    Psyduck.Mans
 */

namespace Application\Direct\Action;

use PHPX\Ext\Direct\Result\Success;
use PHPX\Proxy\DynamicProxy;
use Propel\Category;
use Propel\CategoryQuery;

/**
 * Class CategoryAction
 * @package Application\Direct\Action
 */
class CategoryAction extends BaseAction {

    /**
     * @var DynamicProxy<\Application\Dao\Impl\CategoryDao>
     */
    private $categoryDao;

    /**
     * @return DynamicProxy<\Application\Dao\Impl\CategoryDao>
     */
    public function loadCategoryDao() {
        if(!$this->categoryDao) {
            $identity = $this->getServiceManager()->get('Accountmanager\Auth\AuthenticationService')->getIdentity();
            $this->categoryDao = DynamicProxy::createFrom(new \Application\Dao\Impl\CategoryDao($identity));
        }
        return $this->categoryDao;
    }

    public function listMethod(array $data) {
        $list = $this->loadCategoryDao()->findByParentId($data[0]['node']);

        $rows = array();
        foreach($list as $category) {
            array_push($rows, array(
                'Id' => $category->getId(),
                'parentId' => $category->getPid(),
                'UserId' => $category->getUserId(),
                'Name' => $category->getName(),
                'leaf' => $category->getChildCount()==0,
                'CreateTime' => $category->getCreateTime(),
                'UpdateTime' => $category->getUpdateTime()
            ));
        }

        return new Success(array('data' => $rows, ''));
    }

    public function addMethod(array $data) {
        $category = new Category();
        $category->setPid($data['parentId']);
        $category->setName($data['Name']);
        $this->loadCategoryDao()->save($category);

        // success return
        return new Success(array('data' => array(
            'Id' => $category->getId(),
            'parentId' => $category->getPid(),
            'UserId' => $category->getUserId(),
            'Name' => $category->getName(),
            'leaf' => $category->getChildCount()==0,
            'CreateTime' => $category->getCreateTime(),
            'UpdateTime' => $category->getUpdateTime()
        )), '添加成功');
    }

    public function editMethod(array $data) {
        $category = $this->loadCategoryDao()->findOneById($data['Id']);
        $category->setName($data['Name']);
        $this->loadCategoryDao()->update($category);

        // success return
        return new Success(array('data' => array(
            'Id' => $category->getId(),
            'parentId' => $category->getPid(),
            'UserId' => $category->getUserId(),
            'Name' => $category->getName(),
            'leaf' => $category->getChildCount()==0,
            'CreateTime' => $category->getCreateTime(),
            'UpdateTime' => $category->getUpdateTime()
        )), '修改成功');
    }

    public function deleteMethod(array $data) {
        $id = $data[0];
        $this->loadCategoryDao()->deleteById($id);
        return new Success(array('data'=>array('Id'=>$id)), '删除成功');
    }
}