<?php

class Service_Model_Service
{

	/**
	 *
	 * @var Zend_Db_Table_Abstract
	 */
	protected $_table;
	
	
	/**
	 * Pulls service data from old database
	 * 
	 * @return Zend_Db_Table_Rowset_Abstract
	 */
	public function loadOldServices()
	{
		$table = new Service_Model_DbTable_Services();
		
		$select = $table->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
			
		$rowSet = $table->fetchAll($select);
		
		return $rowSet;
	}
	
	
	public function loadOldServiceById($id)
	{
	    $table = new Service_Model_DbTable_Services();
	    
	    $select = $table->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
	    ->setIntegrityCheck(false);
	    
	    $select->where('Record_Id = ?', $id);
	    
	    $rowSet = $table->fetchRow($select);
	    
	    return $rowSet;
	}
	
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
	 * @param unknown $id
	 * @return Ambigous <Zend_Db_Table_Row_Abstract, NULL, unknown>
	 */
	public function loadById($id)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('service.id = ?', $id)
			->joinLeft('owner', 'service.owner = owner.id', array('name'))
			->joinLeft('employee', 'service.employee = employee.employee_id', array('first_name', 'last_name'))
			->joinLeft('pump', 'service.pump = pump.id', array('id as pump_id', 'pump_model'))
			->joinLeft('employee as employee_2', 'service.created = employee_2.employee_id', array('employee_id as created_id', 'first_name as create_first', 'last_name as create_last'));

		
		$rowSet = $this->getTable()->fetchRow($select);
		
		return $rowSet;
	}
	
	
	
	/**
	 * 
	 * @param unknown $location
	 * @return Zend_Db_Table_Rowset_Abstract
	 */
	public function loadByLocation($location,$page)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('location = ?', $location)
			->joinLeft('employee', 'service.employee = employee.employee_id', array('employee_id', 'first_name', 'last_name'))
		->order('date DESC');
		
		$paginator = Zend_Paginator::factory($select);
		$paginator->setItemCountPerPage(5)
		->setPageRange(10)
		->setCurrentPageNumber($page);
		return $paginator;
		
	}
	
	
	public function loadActiveServiceByDate($startDate, $endDate, $page)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('service.status = ?', 'Open')
			->where('date >= ?', $startDate)
			->where('date <= ?', $endDate)
			->joinLeft('location', 'service.location = location.id', array('id as location_id', 'street', 'city'))
			->joinLeft('employee', 'service.employee = employee.employee_id', array('first_name','last_name'));
		
	
		
		$paginator = Zend_Paginator::factory($select);
		$paginator->setItemCountPerPage(5)
		->setPageRange(10)
		->setCurrentPageNumber($page);
		return $paginator;
	}
	
	/**
	 * 
	 * @param unknown $location
	 * @return Zend_Db_Table_Rowset_Abstract
	 */
	public function loadAllServiceByLocation($location)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('location = ?', $location)->order('date DESC')
			->joinLeft('owner', 'service.owner = owner.id', array('id as owner_id','name'));
		
		$rowSet = $this->getTable()->fetchAll($select);
		
		return $rowSet;
	}
	
	
	/**
	 * 
	 * @param int $locationId
	 */
	public function loadPastWorkOrders($locationId) {
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('service.status = ?', 'Closed')
		->where('location = ?', $locationId)
		->joinLeft('location', 'service.location = location.id', array('id as location_id', 'street', 'city'))
		->joinLeft('employee', 'service.employee = employee.employee_id', array('first_name','last_name'));
		
		$rowSet = $this->getTable()->fetchAll($select);
		
		return $rowSet;
	}
	
	/**
	 * 
	 * @param unknown $location
	 * @param unknown $employee
	 * @param unknown $date
	 * @param unknown $description
	 * @return mixed
	 */
	public function create($location,$owner,$employee,$date,$description,$complaint,
	        $directions,$status,$flowTest,$pump,$create,$oldId,$startTime=0, $endTime=0)
	{
		$data = array(
				'location' => $location,
				'owner' => $owner,
				'created' => $create,
				'employee' => $employee,
				'date' => $date,
				'description' => $description,
				'old_id' => $oldId,
				'complaint' => $complaint,
				'directions' => $directions,
				'pump' => $pump,
				'status' => $status,
				'flow_test' => $flowTest,
		        'start_time' => $startTime,
		        'end_time' => $endTime
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
	
	/**
	 * 
	 * @param unknown $id
	 * @param unknown $date
	 * @param unknown $description
	 */
	public function edit($id,$ownerId,$employee,$date,$description,$complaint,$directions,$status,
	        $flowTest,$pump,$startTime=0, $endTime=0)
	{
		$data = array(
				'owner' => $ownerId,
				'employee' => $employee,
				'date' => $date,
				'description' => $description,
				'complaint' => $complaint,
				'directions' => $directions,
				'pump' => $pump,
				'status' => $status,
				'flow_test' => $flowTest,
		        'start_time' => $startTime,
		        'end_time' => $endTime
				);
		
		
		
		$where = $this->getTable()->getDefaultAdapter()->quoteInto('id = ?', $id);
		
		$this->getTable()->update($data, $where);
	}
	
	public function remove($id)
	{
		$where = $this->getTable()->getDefaultAdapter()->quoteInto('id = ?', $id);
		
		$this->getTable()->delete($where);
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
			$this->_table = new Service_Model_DbTable_Service();
			return $this->_table;
		}
	}
}

