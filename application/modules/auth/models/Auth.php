<?php
/**
 * Quinns Well And Pump
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.i-support-services.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@i-support-services.com so we can send you a copy immediately.
 *
 * @category   Auth
 * @package    Model
 * @copyright  Copyright (c) Jaimie Garner 2013 I Support Services Inc. (http://www.i-support-services.com)
 * @license    http://www.i-support-services.com/license/new-bsd     New BSD License
 * @version    $Id$
 */
class Auth_Model_Auth
{

	/**
	 *
	 * @var Zend_Db_Table_Abstract
	 */
	protected $_table;
	
	/**
	 *
	 * @var unknown
	 */
	protected $_cache;
	
	/**
	 *
	 */
	public function __construct()
	{
		$cacheManager =  Zend_Registry::get('cacheMan');
		$this->_cache = $cacheManager->getCache('coreCache');
	}
	
	public function loadAuthUser($authId)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('auth_id = ?', $authId);
	}
	
	/**
	 * 
	 * @param unknown $authId
	 * @param unknown $lastSignin
	 * @param unknown $lastIp
	 */
	public function setLastSigngin($authId, $lastSignin, $lastIp)
	{
		$data = array(
				'last_signin' => $lastSignin,
				'last_ip' => $lastIp,
				);
		
		$where = 'auth_id = ' . $authId;
		
		$this->getTable()->update($data, $where);
	}
	
	/**
	 * 
	 * @param unknown $email
	 * @param unknown $password
	 * @param unknown $type
	 * @param unknown $id
	 * @param unknown $status
	 */
	public function create($email,$password,$type,$id,$status)
	{
		$data = array(
				'email'	=> $email,
				'password' => $password,
				'type' => $type,
				'id' => $id,
				'status' => $status
				);
		
		$authId = $this->getTable()->insert($data);
		
		return $authId;
	}
	
	/**
	 * 
	 * @param unknown $id
	 * @param unknown $type
	 * @param unknown $email
	 * @param unknown $password
	 * @param unknown $status
	 * @param unknown $acl
	 */
	public function edit($id,$type,$email,$password,$status,$acl)
	{
		$data = array(
				'email' => $email,
				'password' => $password,
				'status' => $status,
				'acl' => $acl,
				);
		$where[] = $this->getTable()->getDefaultAdapter()->quoteInto('id = ?', $id);
		$where[] = $this->getTable()->getDefaultAdapter()->quoteInto('type = ?', $type);
		
		$this->getTable()->update($data, $where);
	}
	
	/**
	 * 
	 * @param unknown $values
	 * @return boolean
	 */
	public function process($values)
	{
	
		// Get our authentication adapter and check credentials
	
		$adapter = $this->_getAuthAdapter();
	
		$adapter->setIdentity($values['email']);
	
		$adapter->setCredential($values['password']);
	
		$auth = Zend_Auth::getInstance();
	
		$result = $auth->authenticate($adapter);
	
		if ($result->isValid()) {
	
			$user = $adapter->getResultRowObject();
	
			$auth->getStorage()->write($user);
	
			return true;
	
		}
	
		return false;
	
	}
	
	/**
	 * 
	 * @return Zend_Auth_Adapter_DbTable
	 */
	protected function _getAuthAdapter() 
	{
	
		$dbAdapter = Zend_Db_Table::getDefaultAdapter();
	
		$authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
	
		$authAdapter->setTableName('auth')
	
		->setIdentityColumn('email')
	
		->setCredentialColumn('password');

		return $authAdapter;
	
	}
	
	/**
	 *
	 */
	public function getTable()
	{
	
		if(null !== $this->_table) {
			return $this->_table;
		} else {
			$this->_table = new Auth_Model_DbTable_Auth();
			return $this->_table;
		}
	}

}

