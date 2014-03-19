<?php

class Application_Model_Error
{

	/**
	 *
	 * @var Zend_Db_Table_Abstract
	 */
	protected $_table;
	
	/**
	 *
	 * @throws Zend_Exception
	 * @return boolean
	 */
	public function __construct()
	{
		$test = new Application_Model_DbTable_Error();
		if($test->verifyTable() == 'ERROR: Table does not exist') {
			if($test->createTable() == 'OK: Created Table') {
	
				return true;
			} else {
				throw new Zend_Exception('Error checking table password');
			}
		}
	
		return true;
	}
	
	/**
	 * 
	 * @param unknown $message
	 * @param unknown $trace
	 * @param unknown $request
	 * @param unknown $date
	 * @return Ambigous <mixed, multitype:>
	 */
	public function recordError($message,$trace,$request,$date)
	{
		$data = array(
				'date'	=> $date,
				'message' => $message,
				'trace' => $trace,
				'request' => $request
				);
		
		$errorId = $this->getTable()->insert($data);
		
		return $errorId;
	}
	
	
	/**
	 *
	 * @return Zend_Db_Table_Abstract
	 */
	public function getTable()
	{
	
		if(null !== $this->_table) {
			return $this->_table;
		} else {
			$this->_table = new Application_Model_DbTable_Error();
			return $this->_table;
		}
	}
}

