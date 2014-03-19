<?php

class TankType_Model_TankType
{

	/**
	 *
	 * @var Zend_Db_Table_Abstract
	 */
	protected $_table;
	
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
	 * @param unknown $value
	 * @param unknown $name
	 * @return mixed
	 */
	public function create($value)
	{
		$data = array(
				'value' => $value,
				);
				
		$id = $this->getTable()->insert($data);
		
		return $id;
	}
	
	public function checkValue($value)
	{
		$tankType = $this->loadByValue($value);
		
		if(empty($tankType)) {
			$this->create($value);
		}
	}
	
	/**
	 *
	 * @param unknown $keyword
	 * @return multitype:
	 */
	public function loadByKeyword($keyword)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
	
		$select->where('value LIKE ?', '%'.$keyword.'%')
		->limit(20);
	
		$rowSet = $this->getTable()->fetchAll($select);
	
		return $rowSet->toArray();
	}
	
	/**
	 *
	 */
	public function getTable()
	{
	
		if(null !== $this->_table) {
			return $this->_table;
		} else {
			$this->_table = new TankType_Model_DbTable_TankType();
			return $this->_table;
		}
	}
}

