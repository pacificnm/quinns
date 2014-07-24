<?php

class Tank_Model_Tank
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
	    
	    $rowSet = $this->getTable()->fetchAll($select);
	    
	    return $rowSet;
	}
	
	
	public function create($pump,$size,$type,$model,$filtration,$oldId=null)
	{
		$data = array(
				'pump' => $pump,
				'size' => $size,
				'type' => $type,
				'model' => $model,
				'filtration' => $filtration,
		        'old_id' => $oldId
				);
		$id = $this->getTable()->insert($data);
		
		return $id;
	}
	
	public function loadByOldId($oldId)
	{
	    $select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
	    ->setIntegrityCheck(false);
	    
	    $select->where('old_id = ?', $oldId);
	    
	    $rowSet = $this->getTable()->fetchRow($select);
	    
	    return $rowSet;
	}
	
	/**
	 * 
	 * @param unknown $id
	 * @param unknown $size
	 * @param unknown $type
	 * @param unknown $model
	 * @param unknown $filtration
	 */
	public function edit($id,$size,$model, $type,$filtration)
	{
		$data = array(
				'size' => $size,
				'type' => $type,
				'model' => $model,
				'filtration' => $filtration
				);
		
		
		$where = $this->getTable()->getDefaultAdapter()->quoteInto('id = ?', $id);
		
		$this->getTable()->update($data, $where);
	}
	
	/**
	 * 
	 * @param unknown $id
	 * @return Ambigous <Zend_Db_Table_Row_Abstract, NULL, unknown>
	 */
	public function loadByPump($id)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('pump = ?', $id);
		
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
			$this->_table = new Tank_Model_DbTable_Tank();
			return $this->_table;
		}
	}

}

