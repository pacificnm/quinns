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
 * @category   Schedule
 * @package    Model
 * @copyright  Copyright (c) Jaimie Garner 2013 I Support Services Inc. (http://www.i-support-services.com)
 * @license    http://www.i-support-services.com/license/new-bsd     New BSD License
 * @version    $Id$
 */
class Schedule_Model_Schedule
{

	/**
	 *
	 * @var Zend_Db_Table_Abstract
	 */
	protected $_table;
	
	public function create($location,$serviceDue)
	{
		$data = array(
				'location' => $location,
				'service_due' => $serviceDue
				);
		
		$id = $this->getTable()->insert($data);
		
		return $id;
	}
	
	/**
	 * 
	 * @param unknown $id
	 * @param unknown $serviceDue
	 */
	public function edit($id,$serviceDue)
	{
		$data = array('service_due' => $serviceDue);
		$where = $this->getTable()->getDefaultAdapter()->quoteInto('id = ?', $id);
		
		$this->getTable()->update($data, $where);
	}
	
	/**
	 * 
	 * @param int $location
	 * @return Zend_Db_Table_Rowset
	 */
	public function loadByLocation($location)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('location = ?', $location);
		
		$rowSet = $this->getTable()->fetchRow($select);
		
		return $rowSet;
	}
	
	/**
	 * 
	 * @param unknown_type $page
	 */
	public function loadThisMonthService($page = 1)
	{
		$startDay = mktime(0, 0, 0, date("m"), 1, date("Y"));
		$endDay = mktime(0, 0, 0, date("m") +1, 1, date("Y"));
	
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
	
		$select->where('service_due >= ?', $startDay)
		->where('service_due <= ?', $endDay)
		->joinLeft('location', 'location = location.id', array('location.id as location', 'street', 'city'))
			->order('service_due');
	
		$paginator = Zend_Paginator::factory($select);
		$paginator->setItemCountPerPage(15)
			->setPageRange(10)
			->setCurrentPageNumber($page);
		return $paginator;
	}
	
	/**
	 * 
	 * @param unknown_type $startDate
	 * @param unknown_type $endDate
	 * @param unknown_type $page
	 */
	public function loadByDate($startDate, $endDate, $page = 1)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('service_due	>= ?', $startDate)
			->where('service_due <= ?', $endDate)
			->joinLeft('location', 'location = location.id', array('location.id as location', 'street', 'city'))
			->joinLeft('owner_location', 'location.id = owner_location.location', array('owner_location.id as owner_location_id'))
			->joinLeft('owner', 'owner_location.owner = owner.id', array('id as owner_id', 'name', 'phone'))
			->group('owner.id')
			->order('service_due');
		
		$paginator = Zend_Paginator::factory($select);
		$paginator->setItemCountPerPage(15)
			->setPageRange(10)
			->setCurrentPageNumber($page);
		return $paginator;
	}
	
	
	public function loadByDateNoPage($startDate, $endDate)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('service_due	>= ?', $startDate)
		->where('service_due <= ?', $endDate)
		->joinLeft('location', 'location = location.id', array('location.id as location', 'street', 'city'))
		->joinLeft('owner_location', 'location.id = owner_location.location', array('owner_location.id as owner_location_id'))
		->joinLeft('owner', 'owner_location.owner = owner.id', array('id as owner_id', 'name', 'phone'))
		->group('owner.id')
		->order('service_due');
		
		$rowSet = $this->getTable()->fetchAll($select);
		
		return $rowSet;
	}
	
	/**
	 *
	 */
	public function getTable()
	{
	
		if(null !== $this->_table) {
			return $this->_table;
		} else {
			$this->_table = new Schedule_Model_DbTable_Schedule();
			return $this->_table;
		}
	}
}

