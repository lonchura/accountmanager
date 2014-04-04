<?php

namespace Propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'category' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.Propel.map
 */
class CategoryTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Propel.map.CategoryTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('category');
        $this->setPhpName('Category');
        $this->setClassname('Propel\\Category');
        $this->setPackage('Propel');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, 4, null);
        $this->addForeignKey('pid', 'Pid', 'INTEGER', 'category', 'id', false, 4, null);
        $this->addColumn('child_count', 'ChildCount', 'INTEGER', true, 2, null);
        $this->addForeignKey('user_id', 'UserId', 'INTEGER', 'user', 'id', true, 4, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 45, null);
        $this->addColumn('create_time', 'CreateTime', 'TIMESTAMP', true, null, null);
        $this->addColumn('update_time', 'UpdateTime', 'TIMESTAMP', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('CategoryRelatedByPid', 'Propel\\Category', RelationMap::MANY_TO_ONE, array('pid' => 'id', ), 'CASCADE', null);
        $this->addRelation('User', 'Propel\\User', RelationMap::MANY_TO_ONE, array('user_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('CategoryRelatedById', 'Propel\\Category', RelationMap::ONE_TO_MANY, array('id' => 'pid', ), 'CASCADE', null, 'CategorysRelatedById');
        $this->addRelation('CategoryResource', 'Propel\\CategoryResource', RelationMap::ONE_TO_MANY, array('id' => 'category_id', ), null, null, 'CategoryResources');
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'timestampable' =>  array (
  'create_column' => 'create_time',
  'update_column' => 'update_time',
  'disable_updated_at' => 'false',
),
        );
    } // getBehaviors()

} // CategoryTableMap
