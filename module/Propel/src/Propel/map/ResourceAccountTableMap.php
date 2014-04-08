<?php

namespace Propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'resource_account' table.
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
class ResourceAccountTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Propel.map.ResourceAccountTableMap';

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
        $this->setName('resource_account');
        $this->setPhpName('ResourceAccount');
        $this->setClassname('Propel\\ResourceAccount');
        $this->setPackage('Propel');
        $this->setUseIdGenerator(true);
        $this->setIsCrossRef(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, 4, null);
        $this->addForeignKey('resource_id', 'ResourceId', 'INTEGER', 'resource', 'id', true, 4, null);
        $this->addForeignKey('account_id', 'AccountId', 'INTEGER', 'account', 'id', true, 3, null);
        $this->addColumn('identity', 'Identity', 'VARCHAR', true, 255, null);
        $this->addColumn('create_time', 'CreateTime', 'TIMESTAMP', true, null, null);
        $this->addColumn('update_time', 'UpdateTime', 'TIMESTAMP', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Resource', 'Propel\\Resource', RelationMap::MANY_TO_ONE, array('resource_id' => 'id', ), null, null);
        $this->addRelation('Account', 'Propel\\Account', RelationMap::MANY_TO_ONE, array('account_id' => 'id', ), null, null);
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

} // ResourceAccountTableMap
