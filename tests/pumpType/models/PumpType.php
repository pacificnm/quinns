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
	 * Checks if there is already a value if not it will create one
	 * @param string $value
	 * @return int <the insert id>
	 */
	public function checkValue($value)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
	
		$select->where('value = ?', $value);
	
		$rowSet = $this->getTable()->fetchRow($select);
	
		if(count($rowSet) < 1) {
			$data = array(
					'value' => $value,
			);
			$id = $this->getTable()->insert($data);
	
			return $id;
		} else {
			return $rowSet->id;
		}
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

