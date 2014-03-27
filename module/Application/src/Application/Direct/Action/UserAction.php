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
use Propel\User;
use Propel\UserPeer;

/**
 * Class UserAction
 * @package Application\Direct\Action
 */
class UserAction extends BaseAction {

    /**
     * @Inject \Application\Dao\Impl\UserDao
     * @var \Application\Dao\Impl\UserDao
     */
    private $userDao;

    public function listMethod(array $data) {
        $page = $data[0];
        $rows = array();

        $result = $this->userDao->find($page);
        foreach($result['list'] as $user) {
            array_push($rows, array(
                'UserId' => $user->getId(),
                'Name' => $user->getName(),
                'NickName' => $user->getNickname(),
                'RoleId' => $user->getRoleId(),
                'CreateTime' => $user->getCreateTime(),
                'UpdateTime' => $user->getUpdateTime()
            ));
        }

        return new Success(array(
            'total' => $result['total'],
            'data' => $rows
        ), '');
    }

    public function editMethod(array $data) {
        // check dupli name
        $user = $this->userDao->findOneByWhere(array(UserPeer::NAME => $data['Name']));
        if($user && $user->getId()!=$data['UserId']) {
            return new Failure('用户名:“'.$data['Name'].'”已存在，请重新命名');
        }
        // check current user
        $user = $this->userDao->getUserById($data['UserId']);
        if(!$user) {
            return new Failure('用户:“'.$data['UserId'].'”，未找到');
        }
        // edit save
        $user->setName($data['Name']);
        $user->setNickname($data['NickName']);
        $user->setRoleId($data['RoleId']);
        if(trim($data['Password'])) {
            $user->setPassword($data['Password']);
        }
        $user->save();
        // success return
        return new Success(array(
            'UserId' => $user->getId(),
            'Name' => $user->getName(),
            'NickName' => $user->getNickname(),
            'RoleId' => $user->getRoleId(),
            'CreateTime' => $user->getCreateTime(),
            'UpdateTime' => $user->getUpdateTime()
        ), '编辑成功');
    }

    public function addMethod(array $data) {
        // check dupli name
        $user = $this->userDao->findOneByWhere(array(UserPeer::NAME => $data['Name']));
        if($user) {
            return new Failure('用户名:“'.$data['Name'].'”已存在，请重新命名');
        }
        // add save
        $user = new User();
        $user->setName($data['Name']);
        $user->setNickname($data['NickName']);
        $user->setRoleId($data['RoleId']);
        $user->setPassword($data['Password']);
        $user->save();
        // success return
        return new Success(array(
            'UserId' => $user->getId(),
            'Name' => $user->getName(),
            'NickName' => $user->getNickname(),
            'RoleId' => $user->getRoleId(),
            'CreateTime' => $user->getCreateTime(),
            'UpdateTime' => $user->getUpdateTime()
        ), '添加成功');
    }

    public function deleteMethod(array $data) {
        $ids = $data[0];
        $this->userDao->deleteRangeByIds($ids);
        return new Success($ids, '删除成功');
    }
}