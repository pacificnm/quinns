<?php

class Security_Model_Security
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
	
	
	public function create($date, $status, $params)
	{
		$data = array(
					'date' 		=> $date,
					'status' 	=> $status,
					'params'	=> $params
				);
		
		$id = $this->getTable()->insert($data);
		
		return $id;
	}
	
	public function loadAll($page, $startDate, $endDate, $status='')
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		
		
		$select->where('date >= ?', $startDate)
			->where('date <= ?', $endDate);
		
	
		if($status != '') {
			$select->where('status = ?', $status);
		}
		
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
			$this->_table = new Security_Model_DbTable_Security();
			return $this->_table;
		}
	}

}

