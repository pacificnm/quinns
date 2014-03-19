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
	
	
	
	/**
	 *
	 * @param unknown $value
	 */
	public function checkValue($value)
	{
		$pipe = $this->loadByValue($value);
	
		if(empty($pipe)) {
			$this->create($value);
		}
	}
	
	/**
	 *
	 * @param unknown $value
	 * @return multitype:unknown
	 */
	public function create($value)
	{
		$data = array(
				'value' => $value
		);
		$id = $this->getTable()->insert($data);
	
		return $id;
	}
	
	/**
	 *
	 * @param unknown $value
	 */
	public function loadByValue($value)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
	
		$select->where('value= ?', $value);
	
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
			$this->_table = new PumpModel_Model_DbTable_PumpModel();
			return $this->_table;
		}
	}
	

}

