<?php

class TankModel_Model_TankModel
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
	
		$select->where('value = ?', $value);
		
		$rowSet = $this->getTable()->fetchRow($select);
	
		return $rowSet;
	}
	
	/**
	 * Loads all
	 * @return Zend_DB_Table_Rowset
	 */
	public function loadAll()
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$rowSet = $this->getTable()->fetchRow($select);
		
		return $rowSet;
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
	
	/**
	 * 
	 * @param unknown $value
	 */
	public function checkValue($value)
	{
		$tankModel = $this->loadByValue($value);
		
		if(empty($tankModel)) {
			$this->create($value);
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
			$this->_table = new TankModel_Model_DbTable_TankModel();
			return $this->_table;
		}
	}
	
}

