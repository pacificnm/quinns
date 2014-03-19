<?php

class Application_Model_City
{

	/**
	 *
	 * @var Zend_Db_Table_Abstract
	 */
	protected $_table;
	
	/**
	 * 
	 * @param string $city
	 * @return mixed
	 */
	public function create($city)
	{
		$data = array('value' => $city);
		
		$id = $this->getTable()->insert($data);
		
		return $id;
	}
	
	/**
	 * 
	 * @param int $id
	 * @param string $city
	 */
	public function edit($id, $city)
	{
		$data = array('value' => $city);
		
		$where = $this->getTable()->getDefaultAdapter()->quoteInto('id = ?', $id);
		
		$this->getTable()->update($data, $where);
	}
	
	/**
	 * 
	 * @param int $id
	 */
	public function remove($id)
	{
		$where = $this->getTable()->getDefaultAdapter()->quoteInto('id = ?', $id);
		
		$this->getTable()->delete($where);
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
	 * @param int $id
	 * @return Zend_Db_Table_Rowset_Abstract
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
	 */
	public function getTable()
	{
	
		if(null !== $this->_table) {
			return $this->_table;
		} else {
			$this->_table = new Application_Model_DbTable_City();
			return $this->_table;
		}
	}
}

