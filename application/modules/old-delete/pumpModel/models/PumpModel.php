<?php

class PumpModel_Model_PumpModel
{
	/**
	 *
	 * @var Zend_Db_Table_Abstract
	 */
	protected $_table;
	
	public function loadOldPumpModel()
	{
		$table = new PumpModel_Model_DbTable_Pumptable();
		
		$select = $table->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$rowSet = $table->fetchAll($select);
		
		return $rowSet;
	}
	
	public function loadByName($name)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('name LIKE ?', $name);
		
		
		$rowSet = $this->getTable()->fetchRow($select);
		
		return $rowSet;
	}
	
	public function create($name, $status)
	{
		$data = array(
			'name' => $name,
			'status' => $status
		);
		
		$id = $this->getTable()->insert($data);
		
		return $id;
	}
	
	/**
	 *
	 */
	public function getTable()
	{
	
		if(null !== $this->_table) {
			return $this->_table;
		} else {
			$this->_table = new PumpModel_Model_DbTable_PumpModel();
			return $this->_table;
		}
	}
	

}

