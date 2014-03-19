<?php

class Renter_Model_Renter
{

	/**
	 *
	 * @var Zend_Db_Table_Abstract
	 */
	protected $_table;
	
	
	/**
	 * 
	 * @param unknown $location
	 * @param unknown $name
	 * @param unknown $phone
	 * @return mixed
	 */
	public function create($location,$name,$phone,$oldId=0)
	{
		$data = array(
				'location' => $location,
				'name' => $name,
				'phone' => $phone,
				'old_id' => $oldId
				);
		$id = $this->getTable()->insert($data);
		
		return $id;
	}
	
	public function loadByLocation($locationId)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('location = ?', $locationId);
		
		$rowSet = $this->getTable()->fetchRow($select);
		
		return $rowSet;
	}
	
	/**
	 * 
	 * @return Zend_Db_Table_Abstract
	 */
	public function getTable()
	{
	
		if(null !== $this->_table) {
			return $this->_table;
		} else {
			$this->_table = new Renter_Model_DbTable_Renter();
			return $this->_table;
		}
	}
}

