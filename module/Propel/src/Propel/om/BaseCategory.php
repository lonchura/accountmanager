<?php

namespace Propel\om;

use \BaseObject;
use \BasePeer;
use \Criteria;
use \DateTime;
use \Exception;
use \PDO;
use \Persistent;
use \Propel;
use \PropelCollection;
use \PropelDateTime;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Propel\Category;
use Propel\CategoryPeer;
use Propel\CategoryQuery;
use Propel\CategoryResource;
use Propel\CategoryResourceQuery;

/**
 * Base class that represents a row from the 'category' table.
 *
 * 资源类别表
 *
 * @package    propel.generator.Propel.om
 */
abstract class BaseCategory extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'Propel\\CategoryPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        CategoryPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinite loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the pid field.
     * @var        int
     */
    protected $pid;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the create_time field.
     * @var        string
     */
    protected $create_time;

    /**
     * The value for the update_time field.
     * @var        string
     */
    protected $update_time;

    /**
     * @var        Category
     */
    protected $aCategoryRelatedByPid;

    /**
     * @var        PropelObjectCollection|Category[] Collection to store aggregation of Category objects.
     */
    protected $collCategorysRelatedById;
    protected $collCategorysRelatedByIdPartial;

    /**
     * @var        PropelObjectCollection|CategoryResource[] Collection to store aggregation of CategoryResource objects.
     */
    protected $collCategoryResources;
    protected $collCategoryResourcesPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInSave = false;

    /**
     * Flag to prevent endless validation loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInValidation = false;

    /**
     * Flag to prevent endless clearAllReferences($deep=true) loop, if this object is referenced
     * @var        boolean
     */
    protected $alreadyInClearAllReferencesDeep = false;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $categorysRelatedByIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $categoryResourcesScheduledForDeletion = null;

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {

        return $this->id;
    }

    /**
     * Get the [pid] column value.
     *
     * @return int
     */
    public function getPid()
    {

        return $this->pid;
    }

    /**
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {

        return $this->name;
    }

    /**
     * Get the [optionally formatted] temporal [create_time] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreateTime($format = 'Y-m-d H:i:s')
    {
        if ($this->create_time === null) {
            return null;
        }

        if ($this->create_time === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->create_time);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->create_time, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [optionally formatted] temporal [update_time] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getUpdateTime($format = 'Y-m-d H:i:s')
    {
        if ($this->update_time === null) {
            return null;
        }

        if ($this->update_time === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->update_time);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->update_time, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Set the value of [id] column.
     *
     * @param  int $v new value
     * @return Category The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = CategoryPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [pid] column.
     *
     * @param  int $v new value
     * @return Category The current object (for fluent API support)
     */
    public function setPid($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->pid !== $v) {
            $this->pid = $v;
            $this->modifiedColumns[] = CategoryPeer::PID;
        }

        if ($this->aCategoryRelatedByPid !== null && $this->aCategoryRelatedByPid->getId() !== $v) {
            $this->aCategoryRelatedByPid = null;
        }


        return $this;
    } // setPid()

    /**
     * Set the value of [name] column.
     *
     * @param  string $v new value
     * @return Category The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = CategoryPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Sets the value of [create_time] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Category The current object (for fluent API support)
     */
    public function setCreateTime($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->create_time !== null || $dt !== null) {
            $currentDateAsString = ($this->create_time !== null && $tmpDt = new DateTime($this->create_time)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->create_time = $newDateAsString;
                $this->modifiedColumns[] = CategoryPeer::CREATE_TIME;
            }
        } // if either are not null


        return $this;
    } // setCreateTime()

    /**
     * Sets the value of [update_time] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Category The current object (for fluent API support)
     */
    public function setUpdateTime($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->update_time !== null || $dt !== null) {
            $currentDateAsString = ($this->update_time !== null && $tmpDt = new DateTime($this->update_time)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->update_time = $newDateAsString;
                $this->modifiedColumns[] = CategoryPeer::UPDATE_TIME;
            }
        } // if either are not null


        return $this;
    } // setUpdateTime()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return true
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
     * @param int $startcol 0-based offset column which indicates which resultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false)
    {
        try {

            $this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->pid = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->name = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->create_time = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->update_time = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 5; // 5 = CategoryPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Category object", $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {

        if ($this->aCategoryRelatedByPid !== null && $this->pid !== $this->aCategoryRelatedByPid->getId()) {
            $this->aCategoryRelatedByPid = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param boolean $deep (optional) Whether to also de-associated any related objects.
     * @param PropelPDO $con (optional) The PropelPDO connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getConnection(CategoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = CategoryPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aCategoryRelatedByPid = null;
            $this->collCategorysRelatedById = null;

            $this->collCategoryResources = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param PropelPDO $con
     * @return void
     * @throws PropelException
     * @throws Exception
     * @see        BaseObject::setDeleted()
     * @see        BaseObject::isDeleted()
     */
    public function delete(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(CategoryPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = CategoryQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @throws Exception
     * @see        doSave()
     */
    public function save(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(CategoryPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior
                if (!$this->isColumnModified(CategoryPeer::CREATE_TIME)) {
                    $this->setCreateTime(time());
                }
                if (!$this->isColumnModified(CategoryPeer::UPDATE_TIME)) {
                    $this->setUpdateTime(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(CategoryPeer::UPDATE_TIME)) {
                    $this->setUpdateTime(time());
                }
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                CategoryPeer::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see        save()
     */
    protected function doSave(PropelPDO $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aCategoryRelatedByPid !== null) {
                if ($this->aCategoryRelatedByPid->isModified() || $this->aCategoryRelatedByPid->isNew()) {
                    $affectedRows += $this->aCategoryRelatedByPid->save($con);
                }
                $this->setCategoryRelatedByPid($this->aCategoryRelatedByPid);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->categorysRelatedByIdScheduledForDeletion !== null) {
                if (!$this->categorysRelatedByIdScheduledForDeletion->isEmpty()) {
                    foreach ($this->categorysRelatedByIdScheduledForDeletion as $categoryRelatedById) {
                        // need to save related object because we set the relation to null
                        $categoryRelatedById->save($con);
                    }
                    $this->categorysRelatedByIdScheduledForDeletion = null;
                }
            }

            if ($this->collCategorysRelatedById !== null) {
                foreach ($this->collCategorysRelatedById as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->categoryResourcesScheduledForDeletion !== null) {
                if (!$this->categoryResourcesScheduledForDeletion->isEmpty()) {
                    CategoryResourceQuery::create()
                        ->filterByPrimaryKeys($this->categoryResourcesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->categoryResourcesScheduledForDeletion = null;
                }
            }

            if ($this->collCategoryResources !== null) {
                foreach ($this->collCategoryResources as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param PropelPDO $con
     *
     * @throws PropelException
     * @see        doSave()
     */
    protected function doInsert(PropelPDO $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[] = CategoryPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . CategoryPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(CategoryPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(CategoryPeer::PID)) {
            $modifiedColumns[':p' . $index++]  = '`pid`';
        }
        if ($this->isColumnModified(CategoryPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '`name`';
        }
        if ($this->isColumnModified(CategoryPeer::CREATE_TIME)) {
            $modifiedColumns[':p' . $index++]  = '`create_time`';
        }
        if ($this->isColumnModified(CategoryPeer::UPDATE_TIME)) {
            $modifiedColumns[':p' . $index++]  = '`update_time`';
        }

        $sql = sprintf(
            'INSERT INTO `category` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id`':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case '`pid`':
                        $stmt->bindValue($identifier, $this->pid, PDO::PARAM_INT);
                        break;
                    case '`name`':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case '`create_time`':
                        $stmt->bindValue($identifier, $this->create_time, PDO::PARAM_STR);
                        break;
                    case '`update_time`':
                        $stmt->bindValue($identifier, $this->update_time, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param PropelPDO $con
     *
     * @see        doSave()
     */
    protected function doUpdate(PropelPDO $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();
        BasePeer::doUpdate($selectCriteria, $valuesCriteria, $con);
    }

    /**
     * Array of ValidationFailed objects.
     * @var        array ValidationFailed[]
     */
    protected $validationFailures = array();

    /**
     * Gets any ValidationFailed objects that resulted from last call to validate().
     *
     *
     * @return array ValidationFailed[]
     * @see        validate()
     */
    public function getValidationFailures()
    {
        return $this->validationFailures;
    }

    /**
     * Validates the objects modified field values and all objects related to this table.
     *
     * If $columns is either a column name or an array of column names
     * only those columns are validated.
     *
     * @param mixed $columns Column name or an array of column names.
     * @return boolean Whether all columns pass validation.
     * @see        doValidate()
     * @see        getValidationFailures()
     */
    public function validate($columns = null)
    {
        $res = $this->doValidate($columns);
        if ($res === true) {
            $this->validationFailures = array();

            return true;
        }

        $this->validationFailures = $res;

        return false;
    }

    /**
     * This function performs the validation work for complex object models.
     *
     * In addition to checking the current object, all related objects will
     * also be validated.  If all pass then <code>true</code> is returned; otherwise
     * an aggregated array of ValidationFailed objects will be returned.
     *
     * @param array $columns Array of column names to validate.
     * @return mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objects otherwise.
     */
    protected function doValidate($columns = null)
    {
        if (!$this->alreadyInValidation) {
            $this->alreadyInValidation = true;
            $retval = null;

            $failureMap = array();


            // We call the validate method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aCategoryRelatedByPid !== null) {
                if (!$this->aCategoryRelatedByPid->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aCategoryRelatedByPid->getValidationFailures());
                }
            }


            if (($retval = CategoryPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collCategorysRelatedById !== null) {
                    foreach ($this->collCategorysRelatedById as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collCategoryResources !== null) {
                    foreach ($this->collCategoryResources as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }


            $this->alreadyInValidation = false;
        }

        return (!empty($failureMap) ? $failureMap : true);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param string $name name
     * @param string $type The type of fieldname the $name is of:
     *               one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *               BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *               Defaults to BasePeer::TYPE_PHPNAME
     * @return mixed Value of field.
     */
    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = CategoryPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getPid();
                break;
            case 2:
                return $this->getName();
                break;
            case 3:
                return $this->getCreateTime();
                break;
            case 4:
                return $this->getUpdateTime();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     *                    BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                    Defaults to BasePeer::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to true.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['Category'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Category'][$this->getPrimaryKey()] = true;
        $keys = CategoryPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getPid(),
            $keys[2] => $this->getName(),
            $keys[3] => $this->getCreateTime(),
            $keys[4] => $this->getUpdateTime(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aCategoryRelatedByPid) {
                $result['CategoryRelatedByPid'] = $this->aCategoryRelatedByPid->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collCategorysRelatedById) {
                $result['CategorysRelatedById'] = $this->collCategorysRelatedById->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCategoryResources) {
                $result['CategoryResources'] = $this->collCategoryResources->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param string $name peer name
     * @param mixed $value field value
     * @param string $type The type of fieldname the $name is of:
     *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                     Defaults to BasePeer::TYPE_PHPNAME
     * @return void
     */
    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = CategoryPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @param mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setPid($value);
                break;
            case 2:
                $this->setName($value);
                break;
            case 3:
                $this->setCreateTime($value);
                break;
            case 4:
                $this->setUpdateTime($value);
                break;
        } // switch()
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     * The default key type is the column's BasePeer::TYPE_PHPNAME
     *
     * @param array  $arr     An array to populate the object from.
     * @param string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = CategoryPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setPid($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setName($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setCreateTime($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setUpdateTime($arr[$keys[4]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(CategoryPeer::DATABASE_NAME);

        if ($this->isColumnModified(CategoryPeer::ID)) $criteria->add(CategoryPeer::ID, $this->id);
        if ($this->isColumnModified(CategoryPeer::PID)) $criteria->add(CategoryPeer::PID, $this->pid);
        if ($this->isColumnModified(CategoryPeer::NAME)) $criteria->add(CategoryPeer::NAME, $this->name);
        if ($this->isColumnModified(CategoryPeer::CREATE_TIME)) $criteria->add(CategoryPeer::CREATE_TIME, $this->create_time);
        if ($this->isColumnModified(CategoryPeer::UPDATE_TIME)) $criteria->add(CategoryPeer::UPDATE_TIME, $this->update_time);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(CategoryPeer::DATABASE_NAME);
        $criteria->add(CategoryPeer::ID, $this->id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Category (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setPid($this->getPid());
        $copyObj->setName($this->getName());
        $copyObj->setCreateTime($this->getCreateTime());
        $copyObj->setUpdateTime($this->getUpdateTime());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getCategorysRelatedById() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCategoryRelatedById($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCategoryResources() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCategoryResource($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return Category Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Returns a peer instance associated with this om.
     *
     * Since Peer classes are not to have any instance attributes, this method returns the
     * same instance for all member of this class. The method could therefore
     * be static, but this would prevent one from overriding the behavior.
     *
     * @return CategoryPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new CategoryPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Category object.
     *
     * @param                  Category $v
     * @return Category The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCategoryRelatedByPid(Category $v = null)
    {
        if ($v === null) {
            $this->setPid(NULL);
        } else {
            $this->setPid($v->getId());
        }

        $this->aCategoryRelatedByPid = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Category object, it will not be re-added.
        if ($v !== null) {
            $v->addCategoryRelatedById($this);
        }


        return $this;
    }


    /**
     * Get the associated Category object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Category The associated Category object.
     * @throws PropelException
     */
    public function getCategoryRelatedByPid(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aCategoryRelatedByPid === null && ($this->pid !== null) && $doQuery) {
            $this->aCategoryRelatedByPid = CategoryQuery::create()->findPk($this->pid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCategoryRelatedByPid->addCategorysRelatedById($this);
             */
        }

        return $this->aCategoryRelatedByPid;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('CategoryRelatedById' == $relationName) {
            $this->initCategorysRelatedById();
        }
        if ('CategoryResource' == $relationName) {
            $this->initCategoryResources();
        }
    }

    /**
     * Clears out the collCategorysRelatedById collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Category The current object (for fluent API support)
     * @see        addCategorysRelatedById()
     */
    public function clearCategorysRelatedById()
    {
        $this->collCategorysRelatedById = null; // important to set this to null since that means it is uninitialized
        $this->collCategorysRelatedByIdPartial = null;

        return $this;
    }

    /**
     * reset is the collCategorysRelatedById collection loaded partially
     *
     * @return void
     */
    public function resetPartialCategorysRelatedById($v = true)
    {
        $this->collCategorysRelatedByIdPartial = $v;
    }

    /**
     * Initializes the collCategorysRelatedById collection.
     *
     * By default this just sets the collCategorysRelatedById collection to an empty array (like clearcollCategorysRelatedById());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCategorysRelatedById($overrideExisting = true)
    {
        if (null !== $this->collCategorysRelatedById && !$overrideExisting) {
            return;
        }
        $this->collCategorysRelatedById = new PropelObjectCollection();
        $this->collCategorysRelatedById->setModel('Category');
    }

    /**
     * Gets an array of Category objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Category is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Category[] List of Category objects
     * @throws PropelException
     */
    public function getCategorysRelatedById($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collCategorysRelatedByIdPartial && !$this->isNew();
        if (null === $this->collCategorysRelatedById || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCategorysRelatedById) {
                // return empty collection
                $this->initCategorysRelatedById();
            } else {
                $collCategorysRelatedById = CategoryQuery::create(null, $criteria)
                    ->filterByCategoryRelatedByPid($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collCategorysRelatedByIdPartial && count($collCategorysRelatedById)) {
                      $this->initCategorysRelatedById(false);

                      foreach ($collCategorysRelatedById as $obj) {
                        if (false == $this->collCategorysRelatedById->contains($obj)) {
                          $this->collCategorysRelatedById->append($obj);
                        }
                      }

                      $this->collCategorysRelatedByIdPartial = true;
                    }

                    $collCategorysRelatedById->getInternalIterator()->rewind();

                    return $collCategorysRelatedById;
                }

                if ($partial && $this->collCategorysRelatedById) {
                    foreach ($this->collCategorysRelatedById as $obj) {
                        if ($obj->isNew()) {
                            $collCategorysRelatedById[] = $obj;
                        }
                    }
                }

                $this->collCategorysRelatedById = $collCategorysRelatedById;
                $this->collCategorysRelatedByIdPartial = false;
            }
        }

        return $this->collCategorysRelatedById;
    }

    /**
     * Sets a collection of CategoryRelatedById objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $categorysRelatedById A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Category The current object (for fluent API support)
     */
    public function setCategorysRelatedById(PropelCollection $categorysRelatedById, PropelPDO $con = null)
    {
        $categorysRelatedByIdToDelete = $this->getCategorysRelatedById(new Criteria(), $con)->diff($categorysRelatedById);


        $this->categorysRelatedByIdScheduledForDeletion = $categorysRelatedByIdToDelete;

        foreach ($categorysRelatedByIdToDelete as $categoryRelatedByIdRemoved) {
            $categoryRelatedByIdRemoved->setCategoryRelatedByPid(null);
        }

        $this->collCategorysRelatedById = null;
        foreach ($categorysRelatedById as $categoryRelatedById) {
            $this->addCategoryRelatedById($categoryRelatedById);
        }

        $this->collCategorysRelatedById = $categorysRelatedById;
        $this->collCategorysRelatedByIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Category objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Category objects.
     * @throws PropelException
     */
    public function countCategorysRelatedById(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collCategorysRelatedByIdPartial && !$this->isNew();
        if (null === $this->collCategorysRelatedById || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCategorysRelatedById) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCategorysRelatedById());
            }
            $query = CategoryQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCategoryRelatedByPid($this)
                ->count($con);
        }

        return count($this->collCategorysRelatedById);
    }

    /**
     * Method called to associate a Category object to this object
     * through the Category foreign key attribute.
     *
     * @param    Category $l Category
     * @return Category The current object (for fluent API support)
     */
    public function addCategoryRelatedById(Category $l)
    {
        if ($this->collCategorysRelatedById === null) {
            $this->initCategorysRelatedById();
            $this->collCategorysRelatedByIdPartial = true;
        }

        if (!in_array($l, $this->collCategorysRelatedById->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddCategoryRelatedById($l);

            if ($this->categorysRelatedByIdScheduledForDeletion and $this->categorysRelatedByIdScheduledForDeletion->contains($l)) {
                $this->categorysRelatedByIdScheduledForDeletion->remove($this->categorysRelatedByIdScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	CategoryRelatedById $categoryRelatedById The categoryRelatedById object to add.
     */
    protected function doAddCategoryRelatedById($categoryRelatedById)
    {
        $this->collCategorysRelatedById[]= $categoryRelatedById;
        $categoryRelatedById->setCategoryRelatedByPid($this);
    }

    /**
     * @param	CategoryRelatedById $categoryRelatedById The categoryRelatedById object to remove.
     * @return Category The current object (for fluent API support)
     */
    public function removeCategoryRelatedById($categoryRelatedById)
    {
        if ($this->getCategorysRelatedById()->contains($categoryRelatedById)) {
            $this->collCategorysRelatedById->remove($this->collCategorysRelatedById->search($categoryRelatedById));
            if (null === $this->categorysRelatedByIdScheduledForDeletion) {
                $this->categorysRelatedByIdScheduledForDeletion = clone $this->collCategorysRelatedById;
                $this->categorysRelatedByIdScheduledForDeletion->clear();
            }
            $this->categorysRelatedByIdScheduledForDeletion[]= $categoryRelatedById;
            $categoryRelatedById->setCategoryRelatedByPid(null);
        }

        return $this;
    }

    /**
     * Clears out the collCategoryResources collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Category The current object (for fluent API support)
     * @see        addCategoryResources()
     */
    public function clearCategoryResources()
    {
        $this->collCategoryResources = null; // important to set this to null since that means it is uninitialized
        $this->collCategoryResourcesPartial = null;

        return $this;
    }

    /**
     * reset is the collCategoryResources collection loaded partially
     *
     * @return void
     */
    public function resetPartialCategoryResources($v = true)
    {
        $this->collCategoryResourcesPartial = $v;
    }

    /**
     * Initializes the collCategoryResources collection.
     *
     * By default this just sets the collCategoryResources collection to an empty array (like clearcollCategoryResources());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCategoryResources($overrideExisting = true)
    {
        if (null !== $this->collCategoryResources && !$overrideExisting) {
            return;
        }
        $this->collCategoryResources = new PropelObjectCollection();
        $this->collCategoryResources->setModel('CategoryResource');
    }

    /**
     * Gets an array of CategoryResource objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Category is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|CategoryResource[] List of CategoryResource objects
     * @throws PropelException
     */
    public function getCategoryResources($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collCategoryResourcesPartial && !$this->isNew();
        if (null === $this->collCategoryResources || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCategoryResources) {
                // return empty collection
                $this->initCategoryResources();
            } else {
                $collCategoryResources = CategoryResourceQuery::create(null, $criteria)
                    ->filterByCategory($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collCategoryResourcesPartial && count($collCategoryResources)) {
                      $this->initCategoryResources(false);

                      foreach ($collCategoryResources as $obj) {
                        if (false == $this->collCategoryResources->contains($obj)) {
                          $this->collCategoryResources->append($obj);
                        }
                      }

                      $this->collCategoryResourcesPartial = true;
                    }

                    $collCategoryResources->getInternalIterator()->rewind();

                    return $collCategoryResources;
                }

                if ($partial && $this->collCategoryResources) {
                    foreach ($this->collCategoryResources as $obj) {
                        if ($obj->isNew()) {
                            $collCategoryResources[] = $obj;
                        }
                    }
                }

                $this->collCategoryResources = $collCategoryResources;
                $this->collCategoryResourcesPartial = false;
            }
        }

        return $this->collCategoryResources;
    }

    /**
     * Sets a collection of CategoryResource objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $categoryResources A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Category The current object (for fluent API support)
     */
    public function setCategoryResources(PropelCollection $categoryResources, PropelPDO $con = null)
    {
        $categoryResourcesToDelete = $this->getCategoryResources(new Criteria(), $con)->diff($categoryResources);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->categoryResourcesScheduledForDeletion = clone $categoryResourcesToDelete;

        foreach ($categoryResourcesToDelete as $categoryResourceRemoved) {
            $categoryResourceRemoved->setCategory(null);
        }

        $this->collCategoryResources = null;
        foreach ($categoryResources as $categoryResource) {
            $this->addCategoryResource($categoryResource);
        }

        $this->collCategoryResources = $categoryResources;
        $this->collCategoryResourcesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related CategoryResource objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related CategoryResource objects.
     * @throws PropelException
     */
    public function countCategoryResources(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collCategoryResourcesPartial && !$this->isNew();
        if (null === $this->collCategoryResources || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCategoryResources) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCategoryResources());
            }
            $query = CategoryResourceQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCategory($this)
                ->count($con);
        }

        return count($this->collCategoryResources);
    }

    /**
     * Method called to associate a CategoryResource object to this object
     * through the CategoryResource foreign key attribute.
     *
     * @param    CategoryResource $l CategoryResource
     * @return Category The current object (for fluent API support)
     */
    public function addCategoryResource(CategoryResource $l)
    {
        if ($this->collCategoryResources === null) {
            $this->initCategoryResources();
            $this->collCategoryResourcesPartial = true;
        }

        if (!in_array($l, $this->collCategoryResources->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddCategoryResource($l);

            if ($this->categoryResourcesScheduledForDeletion and $this->categoryResourcesScheduledForDeletion->contains($l)) {
                $this->categoryResourcesScheduledForDeletion->remove($this->categoryResourcesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	CategoryResource $categoryResource The categoryResource object to add.
     */
    protected function doAddCategoryResource($categoryResource)
    {
        $this->collCategoryResources[]= $categoryResource;
        $categoryResource->setCategory($this);
    }

    /**
     * @param	CategoryResource $categoryResource The categoryResource object to remove.
     * @return Category The current object (for fluent API support)
     */
    public function removeCategoryResource($categoryResource)
    {
        if ($this->getCategoryResources()->contains($categoryResource)) {
            $this->collCategoryResources->remove($this->collCategoryResources->search($categoryResource));
            if (null === $this->categoryResourcesScheduledForDeletion) {
                $this->categoryResourcesScheduledForDeletion = clone $this->collCategoryResources;
                $this->categoryResourcesScheduledForDeletion->clear();
            }
            $this->categoryResourcesScheduledForDeletion[]= clone $categoryResource;
            $categoryResource->setCategory(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Category is new, it will return
     * an empty collection; or if this Category has previously
     * been saved, it will retrieve related CategoryResources from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Category.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|CategoryResource[] List of CategoryResource objects
     */
    public function getCategoryResourcesJoinResource($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = CategoryResourceQuery::create(null, $criteria);
        $query->joinWith('Resource', $join_behavior);

        return $this->getCategoryResources($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->pid = null;
        $this->name = null;
        $this->create_time = null;
        $this->update_time = null;
        $this->alreadyInSave = false;
        $this->alreadyInValidation = false;
        $this->alreadyInClearAllReferencesDeep = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volume/high-memory operations.
     *
     * @param boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep && !$this->alreadyInClearAllReferencesDeep) {
            $this->alreadyInClearAllReferencesDeep = true;
            if ($this->collCategorysRelatedById) {
                foreach ($this->collCategorysRelatedById as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCategoryResources) {
                foreach ($this->collCategoryResources as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aCategoryRelatedByPid instanceof Persistent) {
              $this->aCategoryRelatedByPid->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collCategorysRelatedById instanceof PropelCollection) {
            $this->collCategorysRelatedById->clearIterator();
        }
        $this->collCategorysRelatedById = null;
        if ($this->collCategoryResources instanceof PropelCollection) {
            $this->collCategoryResources->clearIterator();
        }
        $this->collCategoryResources = null;
        $this->aCategoryRelatedByPid = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(CategoryPeer::DEFAULT_STRING_FORMAT);
    }

    /**
     * return true is the object is in saving state
     *
     * @return boolean
     */
    public function isAlreadyInSave()
    {
        return $this->alreadyInSave;
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     Category The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[] = CategoryPeer::UPDATE_TIME;

        return $this;
    }

}
