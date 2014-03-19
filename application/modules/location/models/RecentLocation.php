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
 * @category   Location
 * @package    Model
 * @copyright  Copyright (c) Jaimie Garner 2013 I Support Services Inc. (http://www.i-support-services.com)
 * @license    http://www.i-support-services.com/license/new-bsd     New BSD License
 * @version    $Id$
 */
class Location_Model_RecentLocation
{
	/**
	 *
	 * @var Zend_Db_Table_Abstract
	 */
	protected $_table;
	
	/**
	 * Creates new employee view log
	 * 
	 * @param int $employee
	 * @param int $location
	 */
	public function create($employee,$location)
	{
		$data = array(
				'employee' => $employee,
				'location' => $location,
				'time' => time()
		);
		$id = $this->getTable()->insert($data);
		
		return $id;
	}
	
	/**
	 * Loads the viewed locations by employee
	 * 
	 * @param int $employee
	 * return Ambigous <Zend_Db_Table_Row_Abstract, NULL, unknown>
	 */
	public function loadByEmployee($employee)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('recent_location.employee = ?', $employee)
			->joinLeft('location', 'location.id = recent_location.location', array('id as location_id','street'))
			->order('time DESC')
			->limit(10);
		
		$rowSet = $this->getTable()->fetchAll($select);
		
		return $rowSet;
	}
	
	
	/**
	 * Loads by the recent location id
	 * 
	 * @param unknown $id
	 * @return Ambigous <Zend_Db_Table_Row_Abstract, NULL, unknown>
	 */
	public function loadById($id)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('id = ?', $id);
		
		$rowSet = $this->getTable()->fetchRow($select);
		
		return $rowSet;
	}
	
	/**
	 * Loads by emplyee and location
	 * 
	 * @param int $employee
	 * @param int $location
	 * 
	 * @return Ambigous <Zend_Db_Table_Row_Abstract, NULL, unknown>
	 */
	public function loadByEmployeeLocation($employee,$location)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('employee = ?', $employee)
			->where('location = ?', $location);
		
		$rowSet = $this->getTable()->fetchRow($select);
		
		return $rowSet;
	}
	
	/**
	 * Removes a record
	 * 
	 * @param int $id
	 */
	public function remove($id)
	{
		$where = $this->getTable()->getDefaultAdapter()->quoteInto('id = ?', $id);
		
		$this->getTable()->delete($where);
	}
	
	/**
	 * Removes all records by the employee
	 * 
	 * @param unknown $employee
	 */
	public function removeAllByEmployee($employee)
	{
		$where = $this->getTable()->getDefaultAdapter()->quoteInto('employee = ?', $employee);
		
		$this->getTable()->delete($where);
	}
	
	/**
	 * Loads Db Table
	 * @return Zend_Db_Table_Abstract
	 */
	public function getTable()
	{
	
		if(null !== $this->_table) {
			return $this->_table;
		} else {
			$this->_table = new Location_Model_DbTable_RecentLocation();
			return $this->_table;
		}
	}

}

