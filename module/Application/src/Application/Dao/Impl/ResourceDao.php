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
            'total' => ResourceQuery::create(null, $criteria)
                    ->filterByUserId($this->identity->getId())
                    ->useCategoryResourceQuery()
                        ->filterByCategoryId($categoryId)
                    ->endUse()
                    ->count(),
            'list' => ResourceQuery::create(null, $criteria)
                    ->filterByUserId($this->identity->getId())
                    ->useCategoryResourceQuery()
                        ->filterByCategoryId($categoryId)
                    ->endUse()
                    ->setOffset($page['start'])
                    ->setLimit($page['limit'])
                    ->find()
        );
    }
}