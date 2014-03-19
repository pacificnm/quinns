<?php

class PipeSize_Model_PipeSize
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
		
		$select->order('id');
		
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
	 * @param unknown $page
	 */
	public function loadAllPaginated($page)
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
	public function checkValue($value)
	{
	    $pipe = $this->loadByValue($value);
	
	    if(empty($pipe)) {
	        $this->create($value);
	    }
	}
	
	/**
	 * 
	 * @param unknown $id
	 * @param unknown $value
	 */
	public function edit($id, $value)
	{
		$data = array('value' => $value);
		
		$where = $this->getTable()->getDefaultAdapter()->quoteInto('id = ?', $id);
		
		$this->getTable()->update($data, $where);
	}
	
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
			$this->_table = new PipeSize_Model_DbTable_PipeSize();
			return $this->_table;
		}
	}

}

