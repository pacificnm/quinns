<?php

class Application_Model_Config
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
	
	public function loadByProperty($property)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('property = ?',$property);
		
		$rowSet = $this->getTable()->fetchRow($select);
		
		return $rowSet->value;
	}
	
	/**
	 *
	 */
	public function getTable()
	{
	
		if(null !== $this->_table) {
			return $this->_table;
		} else {
			$this->_table = new Application_Model_DbTable_Config();
			return $this->_table;
		}
	}
}

