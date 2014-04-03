<?php

namespace Propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'resource' table.
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
class ResourceTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Propel.map.ResourceTableMap';

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
        $this->setName('resource');
        $this->setPhpName('Resource');
        $this->setClassname('Propel\\Resource');
        $this->setPackage('Propel');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, 4, null);
        $this->addForeignKey('user_id', 'UserId', 'INTEGER', 'user', 'id', true, 4, null);
        $this->addColumn('identifier', 'Identifier', 'VARCHAR', true, 255, null);
        $this->addColumn('type', 'Type', 'ENUM', true, null, null);
        $this->getColumn('type', false)->setValueSet(array (
  0 => 'Website',
  1 => 'Database',
  2 => 'Server',
  3 => 'Payment',
));
        $this->addColumn('name', 'Name', 'VARCHAR', true, 128, null);
        $this->addColumn('description', 'Description', 'LONGVARCHAR', false, null, null);
        $this->addColumn('create_time', 'CreateTime', 'TIMESTAMP', true, null, null);
        $this->addColumn('update_time', 'UpdateTime', 'TIMESTAMP', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('User', 'Propel\\User', RelationMap::MANY_TO_ONE, array('user_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('ResourceAccount', 'Propel\\ResourceAccount', RelationMap::ONE_TO_MANY, array('id' => 'resource_id', ), null, null, 'ResourceAccounts');
        $this->addRelation('CategoryResource', 'Propel\\CategoryResource', RelationMap::ONE_TO_MANY, array('id' => 'resource_id', ), null, null, 'CategoryResources');
        $this->addRelation('Account', 'Propel\\Account', RelationMap::MANY_TO_MANY, array(), null, null, 'Accounts');
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

} // ResourceTableMap
