<?php

class Pipe_Model_Pipe
{

	/**
	 *
	 * @var Zend_Db_Table_Abstract
	 */
	protected $_table;
	
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
	 * @param int $page
	 * @return Ambigous <Zend_Paginator, Zend_Paginator>
	 */
	public function loadAll($page)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$paginator = Zend_Paginator::factory($select);
		
		$paginator->setItemCountPerPage(10)
		->setPageRange(10)
		->setCurrentPageNumber($page);
		return $paginator;
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
		$pipe = $this->loadByValue($value);
		
		if(empty($pipe)) {
			$this->create($value);
		}
	}
	
	
	/**
	 * 
	 * @param int $id
	 * @param string $value
	 */
	public function edit($id,$value)
	{
		$data = array('value' => $value);
		
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
	 */
	public function getTable()
	{
	
		if(null !== $this->_table) {
			return $this->_table;
		} else {
			$this->_table = new Pipe_Model_DbTable_Pipe();
			return $this->_table;
		}
	}
}

