<?php

class State_Model_State
{
	/**
	 *
	 * @var Zend_Db_Table_Abstract
	 */
	protected $_table;
	
	/**
	 *
	 * @param unknown $value
	 * @return mixed
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
	 * @param unknown $id
	 * @param unknown $value
	 */
	public function edit($id,$value)
	{
		$data = array(
				'value' => $value
		);
		
		$where = $this->getTable()->getDefaultAdapter()->quoteInto('id = ?', $id);
		
		$this->getTable()->update($data, $where);
	}
	
	/**
	 * 
	 * @param unknown $id
	 */
	public function remove($id)
	{
		$where = $this->getTable()->getDefaultAdapter()->quoteInto('id = ?', $id);
		
		$this->getTable()->delete($where);
	}
	
	/**
	 *
	 * @param unknown $value
	 * @return Ambigous <Zend_Db_Table_Row_Abstract, NULL, unknown>
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
	 * @return Zend_Db_Table_Rowset_Abstract
	 */
	public function loadAll()
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$rowSet = $this->getTable()->fetchAll($select);
		
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
		
		$select->where('id = ?', $id);
		
		$rowSet = $this->getTable()->fetchRow($select);
		
		return $rowSet;
	}
	
	
	/**
	 *
	 * @param unknown $value
	 */
	public function checkValue($value)
	{
		$city = $this->loadByValue($value);
	
		if(empty($city)) {
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
			$this->_table = new State_Model_DbTable_State();
			return $this->_table;
		}
	}

}

