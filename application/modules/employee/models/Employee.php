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
 * @category   Employee
 * @package    Model
 * @copyright  Copyright (c) Jaimie Garner 2013 I Support Services Inc. (http://www.i-support-services.com)
 * @license    http://www.i-support-services.com/license/new-bsd     New BSD License
 * @version    $Id$
 */
class Employee_Model_Employee
{

	/**
	 *
	 * @var Zend_Db_Table_Abstract
	 */
	protected $_table;
	
	
	/**
	 *
	 */
	public function __construct()
	{
		
	}
	
	/**
	 * 
	 * @param unknown $firstName
	 * @param unknown $lastName
	 * @param unknown $email
	 * @param unknown $workPhone
	 * @param unknown $mobilePhone
	 * @param unknown $homePhone
	 * @param unknown $jobTitle
	 * @param unknown $address
	 * @param unknown $im
	 * @param unknown $vehicle
	 * @param unknown $status
	 * @return mixed
	 */
	public function create($firstName,$lastName,$email,$workPhone,$mobilePhone,$homePhone,
    					$jobTitle,$address,$im,$vehicle,$status)
	{
		$data = array(
				'first_name' => $firstName,
				'last_name' => $lastName,
				'email' => $email,
				'work_phone' => $workPhone,
				'mobile_phone' => $mobilePhone,
				'home_phone' => $homePhone,
				'job_title' => $jobTitle,
				'im' => $im,
				'address' => $address,
				'vehicle' => $vehicle,
				'status' => $status,
				
				);
		
		$employeeId = $this->getTable()->insert($data);
		
		return $employeeId;
	}
	
	
	/**
	 * 
	 * @param unknown $id
	 * @param unknown $firstName
	 * @param unknown $lastName
	 * @param unknown $email
	 * @param unknown $workPhone
	 * @param unknown $mobilePhone
	 * @param unknown $homePhone
	 * @param unknown $jobTitle
	 * @param unknown $address
	 * @param unknown $im
	 * @param unknown $vehicle
	 * @param unknown $status
	 */
	public function edit($id,$firstName,$lastName,$email,$workPhone,$mobilePhone,$homePhone,
    			 		$jobTitle,$address,$im,$vehicle,$status)
	{
		$data = array(
				'first_name' => $firstName,
				'last_name' => $lastName,
				'email' => $email,
				'work_phone' => $workPhone,
				'mobile_phone' => $mobilePhone,
				'home_phone' => $homePhone,
				'job_title' => $jobTitle,
				'im' => $im,
				'address' => $address,
				'vehicle' => $vehicle,
				'status' => $status,
				);
		$where = $this->getTable()->getDefaultAdapter()->quoteInto('employee_id = ?', $id);
		
		$this->getTable()->update($data, $where);
	}
	
	public function delete()
	{
		
	}
	
	/**
	 * 
	 * @param int $employeeId
	 */
	public function loadById($employeeId)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
			->setIntegrityCheck(false);
		
		$select
			->join('auth', 'auth.id = employee.employee_id')
			->where('employee.employee_id = ?', $employeeId)
			->where('auth.type = ?', 'employee');
		
		$row = $this->getTable()->fetchRow($select);
		
		return $row;
	}
	
	/**
	 * 
	 * @param unknown $first
	 * @param unknown $last
	 * @return Ambigous <Zend_Db_Table_Row_Abstract, NULL, unknown>
	 */
	public function loadByName($first,$last)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('first_name = ?', $first)
			->where('last_name = ?', $last);
		
		$rowSet = $this->getTable()->fetchRow($select);
		
		return $rowSet;
	}
	
	public function loadAllActive($status)
	{
		
			$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
			->setIntegrityCheck(false);
		
			$select
			->joinLeft('auth', 'auth.id = employee.employee_id')
			->where('auth.type = ?', 'employee')
			->where('employee.status = ?', $status);
		
			$rowSet = $this->getTable()->fetchAll($select);
			
		
		return $rowSet;
	}
	
	public function remove($id)
	{
		$where = $this->getTable()->getDefaultAdapter()->quoteInto('employee_id = ?', $id);
		
		$this->getTable()->delete($where);
	}
	
	
	/**
	 * 
	 */
	public function getTable()
	{
	
		if(null !== $this->_table) {
			return $this->_table;
		} else {
			$this->_table = new Employee_Model_DbTable_Employee();
			return $this->_table;
		}
	}
}

