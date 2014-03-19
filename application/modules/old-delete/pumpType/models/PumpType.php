<?php

class PumpType_Model_PumpType
{

	/**
	 *
	 * @var Zend_Db_Table_Abstract
	 */
	protected $_table;
	
	public function loadByName($name)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('name LIKE ?', $name);
		
		
		$rowSet = $this->getTable()->fetchRow($select);
		
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
			$this->_table = new PumpType_Model_DbTable_PumpType();
			return $this->_table;
		}
	}
}

