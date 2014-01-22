<?php

namespace Propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'category_resource' table.
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
class CategoryResourceTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Propel.map.CategoryResourceTableMap';

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
        $this->setName('category_resource');
        $this->setPhpName('CategoryResource');
        $this->setClassname('Propel\\CategoryResource');
        $this->setPackage('Propel');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('category_id', 'CategoryId', 'INTEGER' , 'category', 'id', true, 4, null);
        $this->addForeignPrimaryKey('resource_id', 'ResourceId', 'INTEGER' , 'resource', 'id', true, 4, null);
        $this->addColumn('create_time', 'CreateTime', 'TIMESTAMP', true, null, null);
        $this->addColumn('update_time', 'UpdateTime', 'TIMESTAMP', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Category', 'Propel\\Category', RelationMap::MANY_TO_ONE, array('category_id' => 'id', ), null, null);
        $this->addRelation('Resource', 'Propel\\Resource', RelationMap::MANY_TO_ONE, array('resource_id' => 'id', ), null, null);
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

} // CategoryResourceTableMap
