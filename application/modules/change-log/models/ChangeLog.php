<?php

class ChangeLog_Model_ChangeLog
{
	/**
	 *
	 * @var Zend_Db_Table_Abstract
	 */
	protected $_table;
	
	/**
	 *
	 * @var Zend_Cache
	 */
	protected $_cache;
	
	/**
	 * loads cache
	 */
	public function __construct()
	{
		$cacheManager =  Zend_Registry::get('cacheMan');
		$this->_cache = $cacheManager->getCache('coreCache');
	}
	
	/**
	 * 
	 * @param unknown_type $module
	 * @param unknown_type $moduleId
	 * @param unknown_type $change
	 */
	public function create($employeeId, $module='default', $controller='index', $requestId='0', $action='index',  $request='', $params='', $uri='')
	{

		$data = array(
				'module' 		=> $module,
				'controller'	=> $controller,
				'action' 		=> $action,
				'request_id'	=> $requestId,
				'date' 			=> time(),
				'employee' 		=> $employeeId,
				'request'		=> $request,
				'params'		=> $params,
				'uri'			=> $uri,
				
				);
		
		$id = $this->getTable()->insert($data);
	}
	
	public function loadByEmployee($employee, $startDate, $endDate, $module='', $page)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('date >= ?', $startDate)
			->where('date <= ?', $endDate);
		
		if($employee > 0) {
			$select->where('employee = ?', $employee);
		}
		
		if(!empty($module)) {
			$select->where('module = ?', $module);
		}
		
		$select->join('employee', 'change_log.employee = employee.employee_id', array('employee_id', 'first_name', 'last_name'));
		
		
			
		$paginator = Zend_Paginator::factory($select);
		$paginator->setItemCountPerPage(25)
		->setPageRange(10)
		->setCurrentPageNumber($page);
		return $paginator;
	}
	
	public function loadAll($page)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->joinLeft('employee', 'change_log.employee = employee.employee_id', array('employee_id', 'first_name', 'last_name'));
		
		$paginator = Zend_Paginator::factory($select);
		$paginator->setItemCountPerPage(25)
		->setPageRange(10)
		->setCurrentPageNumber($page);
		return $paginator;
	}
	
	public function loadById($id)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('id = ?', $id)
			->joinLeft('employee', 'change_log.employee = employee.employee_id', array('employee_id', 'first_name', 'last_name'));
		
		$rowSet = $this->getTable()->fetchRow($select);
		
		return $rowSet;
		
	}
	
	
	/**
	 * 
	 * @param unknown_type $uri
	 * @param unknown_type $startDate
	 * @param unknown_type $endDate
	 * @param unknown_type $employee
	 * @param unknown_type $page
	 */
	public function loadByUri($uri, $startDate, $endDate, $employee, $page)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('uri = ?', $uri)
			->where('date >= ?', $startDate)
			->where('date <= ?', $endDate);
			
			
		if($employee > 0) {
			$select->where('employee = ?', $employee);
		}
		
		$select->join('employee', 'change_log.employee = employee.employee_id', array('employee_id', 'first_name', 'last_name'));
		
		$paginator = Zend_Paginator::factory($select);
		$paginator->setItemCountPerPage(25)
		->setPageRange(10)
		->setCurrentPageNumber($page);
		return $paginator;
	}
	
	/**
	 * Loads the Location Databas Table
	 *
	 * @return Zend_Db_Table_Abstract
	 */
	public function getTable()
	{
	
		if(null !== $this->_table) {
			return $this->_table;
		} else {
			$this->_table = new ChangeLog_Model_DbTable_ChangeLog();
			return $this->_table;
		}
	}

}

