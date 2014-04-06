<?php
/**
 * Account Manager System (https://github.com/PsyduckMans/accountmanager)
 *
 * @link      https://github.com/PsyduckMans/accountmanager for the canonical source repository
 * @copyright Copyright (c) 2014 PsyduckMans (https://ninth.not-bad.org)
 * @license   https://github.com/PsyduckMans/accountmanager/blob/master/LICENSE MIT
 * @author    Psyduck.Mans
 */

namespace Application\Dao\Impl;
use Propel\Resource;
use Propel\ResourcePeer;
use Propel\ResourceQuery;

/**
 * Class ResourceDao
 * @package Application\Dao\Impl
 */
class ResourceDao implements \Application\Dao\ResourceDao {
    /**
     * @var \Application\Auth\Identity
     */
    private $identity;

    /**
     * @param \Application\Auth\Identity $identity
     */
    public function __construct(\Application\Auth\Identity $identity) {
        $this->identity = $identity;
    }

    /**
     * @param $categoryId
     * @param array $page Ext direct page request
     * @return array(
     *      'total' => int
     *      'list' => \PropelObjectCollection
     * )
     */
    public function findByCategoryId($categoryId, array $page)
    {
        $criteria = new \Criteria();
        if(isset($page['sort']) && is_array($page['sort'])) {
            foreach($page['sort'] as $sort) {
                \PHPX\Propel\Util\Ext\Direct\Criteria::bindSort(
                    $criteria,
                    array_merge($sort, array(
                            'column' => ResourcePeer::$modelFieldMapping[$sort['property']]
                        )
                    ));
            }
        }

        return array(
            'total' => ResourceQuery::create(null, $criteria)->filterByCategoryId($categoryId)->count(),
            'list' => ResourceQuery::create(null, $criteria)->filterByCategoryId($categoryId)
                        ->setOffset($page['start'])
                        ->setLimit($page['limit'])
                        ->find()
        );
    }

    /**
     * @param \Propel\Resource|Resource $resource
     * @throws \Application\Dao\RuntimeException
     * @return int
     */
    public function save(Resource $resource) {
        try {
            $rowsAffected = $resource->save();
        } catch(\Exception $e) {
            throw new \Application\Dao\RuntimeException('save($resource) failed', 0, $e);
        }
        return $rowsAffected;
    }

    /**
     * @param $id
     * @return \Propel\Resource|null
     */
    public function findOneById($id)
    {
        return ResourceQuery::create()->findOneById($id);
    }

    /**
     * @param array $ids
     * @return int
     */
    public function deleteRangeByIds(array $ids) {
        $criteria = new \Criteria();
        $criteria->addAnd(ResourcePeer::ID, $ids, \Criteria::IN);
        return ResourceQuery::create(null, $criteria)->delete();
    }
}