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
 * @category   PumpTest
 * @package    Model
 * @copyright  Copyright (c) Jaimie Garner 2013 I Support Services Inc. (http://www.i-support-services.com)
 * @license    http://www.i-support-services.com/license/new-bsd     New BSD License
 * @version    $Id$
 */
class PumpTest_Model_PumpTest
{

	/**
	 *
	 * @var Zend_Db_Table_Abstract
	 */
	protected $_table;
	
	public function loadAll()
	{
	    $select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
	    ->setIntegrityCheck(false);
	    
	    $rowSet = $this->getTable()->fetchAll($select);
	    
	    return $rowSet;
	}
	
	/**
	 * 
	 * @param unknown $location
	 * @return Zend_Db_Table_Rowset_Abstract
	 */
	public function loadByLocation($location)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('location = ?', $location)
			->joinLeft('employee', 'pump_test.employee = employee.employee_id', array('first_name', 'last_name'))
			->joinLeft('owner', 'pump_test.owner = owner.id', array('name'))
			->order('pump_test.date DESC');

		
		$rowSet = $this->getTable()->fetchAll($select);
		
		return $rowSet;
	}
	
	/**
	 * 
	 * @param unknown $location
	 * @return Ambigous <Zend_Db_Table_Row_Abstract, NULL, unknown>
	 */
	public function loadByLocationLast($location)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('location = ?', $location)
		->joinLeft('employee', 'pump_test.employee = employee.employee_id', array('first_name', 'last_name'))
		->joinLeft('owner', 'pump_test.owner = owner.id', array('name'))
		->order('pump_test.date DESC');
		
		
		$rowSet = $this->getTable()->fetchRow($select);
		
		return $rowSet;
	}
	
	/**
	 * 
	 * @param int $id
	 * @return Zend_Db_Table_Row_Abstract
	 */
	public function loadById($id)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('pump_test.id = ?', $id)
			->joinLeft('employee', 'pump_test.employee = employee.employee_id', array('first_name', 'last_name'))
			->joinLeft('owner', 'pump_test.owner = owner.id', array('name'));
		
		$rowSet = $this->getTable()->fetchRow($select);
		
		return $rowSet;
	}
	
	/**
	 * 
	 * @param unknown_type $oldId
	 */
	public function loadByOldId($oldId)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('old_id = ?', $oldId);
		
		$rowSet = $this->getTable()->fetchRow($select);
		
		return $rowSet;
	}
	
	/**
	 * 
	 * @param unknown $location
	 * @param unknown $owner
	 * @param unknown $requirements
	 * @param unknown $source
	 * @param unknown $depth
	 * @param unknown $diameter
	 * @param unknown $equipment
	 * @param unknown $level
	 * @param unknown $vent
	 * @param unknown $seal
	 * @param unknown $popOffValve
	 * @param unknown $color
	 * @param unknown $taste
	 * @param unknown $odor
	 * @param unknown $employee
	 * @param unknown $remarks
	 * @param unknown $date
	 * @return mixed
	 */
	public function create($location,$owner,$requirements,$source,$depth,$diameter,
			$equipment,$level,$vent,$seal,$popOffValve,$color,$taste,$odor,$employee,
			$remarks,$date,$oldId=0)
	{
		$data = array(
				'location' => $location,
				'owner' => $owner,
				'requirements' => $requirements,
				'source' => $source,
				'depth' => $depth,
				'diameter' => $diameter,
				'equipment' => $equipment,
				'level' => $level,
				'vent' => $vent,
				'seal' => $seal,
				'pop_off_valve' => $popOffValve,
				'color' => $color,
				'taste' => $taste,
				'odor' => $odor,
				'employee' => $employee,
				'remarks' => $remarks,
				'date' => $date,
				'old_id' => $oldId
				);
		try{
		  $id = $this->getTable()->insert($data);
		
		  return $id;
		  } catch (Exception $e) {
		      $stream = @fopen(APPLICATION_PATH . '/log/database.txt', 'a',
		              false);
		      if (! $stream) {
		          throw new Exception('Failed to open stream');
		      }
		      $writer = new Zend_Log_Writer_Stream($stream);
		      $logger = new Zend_Log($writer);
		      $logger->info($e);
		  }
	}
	
	public function edit($id,$owner,$requirements,$source,$depth,$diameter,
			$equipment,$level,$vent,$seal,$popOffValve,$color,$taste,$odor,$employee,
			$remarks,$date)
	{
		$data = array(
				'owner' => $owner,
				'requirements' => $requirements,
				'source' => $source,
				'depth' => $depth,
				'diameter' => $diameter,
				'equipment' => $equipment,
				'level' => $level,
				'vent' => $vent,
				'seal' => $seal,
				'pop_off_valve' => $popOffValve,
				'color' => $color,
				'taste' => $taste,
				'odor' => $odor,
				'employee' => $employee,
				'remarks' => $remarks,
				'date' => $date
		);
		
		$where = $this->getTable()->getDefaultAdapter()->quoteInto('id = ?', $id);
		
	
		
		$this->getTable()->update($data, $where);
	}
	
	/**
	 * 
	 * @param unknown $pumptestId
	 */
	public function delete($pumptestId)
	{
	    
	    $where = $this->getTable()->getDefaultAdapter()->quoteInto('id = ?', $pumptestId);
	    
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
			$this->_table = new PumpTest_Model_DbTable_PumpTest();
			return $this->_table;
		}
	}
}

