<?php
/**
 * Author: Psyduck.Mans
 */

namespace Propel\Session;

use Propel\Session;
use Propel\SessionPeer;
use Propel\SessionQuery;

use Zend\Session\SaveHandler\SaveHandlerInterface;

/**
 * Class SaveHandler
 * @package Propel\Session
 * @reference http://cn2.php.net/session_set_save_handler
 */
class SaveHandler implements SaveHandlerInterface {
    /**
     * session name
     *
     * @var string
     */
    private $name;

    /**
     * Open Session - retrieve resources
     *
     * @param string $savePath
     * @param string $name
     * @return bool
     */
    public function open($savePath, $name)
    {
        $this->name = $name;
        return \Propel::isInit();
    }

    /**
     * Close Session - free resources
     *
     */
    public function close()
    {
        return \Propel::close();
    }

    /**
     * Read session data
     *
     * @param string $id
     * @return string
     */
    public function read($id)
    {
        $session = SessionQuery::create()->findPk(array($id, $this->name));
        if($session) {
            return $session->getData();
        }
        return '';
    }

    /**
     * Write Session - commit data to resource
     *
     * @param string $id
     * @param mixed $data
     * @return int
     */
    public function write($id, $data)
    {
        $session = SessionQuery::create()->findPk(array($id, $this->name));
        if(!$session) {
            $session = new Session();
        }
        $session->setId($id);
        $session->setName($this->name);
        $session->setData($data);
        return $session->save();
    }

    /**
     * Destroy Session - remove data from resource for
     * given session id
     *
     * @param string $id
     */
    public function destroy($id)
    {
        $session = SessionQuery::create()->findPk(array($id, $this->name));
        if($session) {
            $session->delete();
        }
    }

    /**
     * Garbage Collection - remove old session data older
     * than $maxlifetime (in seconds)
     *
     * @param int $maxlifetime
     */
    public function gc($maxlifetime)
    {
        $criteria = new \Criteria();
        $criteria->add(SessionPeer::CREATE_TIME, date('Y-m-d H:i:s', time()-$maxlifetime), \Criteria::LESS_THAN);
        SessionQuery::create(null, $criteria)->delete();
    }
}