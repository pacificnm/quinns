<?php

class Owner_Model_OwnerLocation
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
		 
		$select
		->joinLeft('owner', 'owner_location.owner = owner.id', array('id as owner_id', 'name', 'phone','street','city','state','zip'));
		
		$rowSet = $this->getTable()->fetchAll($select);
		
		return $rowSet;
	}
	
	
	/**
	 * 
	 * @param unknown $id
	 * @return Ambigous <Zend_Db_Table_Row_Abstract, NULL, unknown>
	 */
	public function loadOwnerByLocation($id)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('location = ?', $id)
			->joinLeft('owner', 'owner_location.owner = owner.id', array('id as owner_id', 'name', 'phone','street','city','state','zip'))
			->order('update');
		try {
    		// only fetch first row
    		$rowSet = $this->getTable()->fetchRow($select);
    		
    		return $rowSet;
		} catch (Exception $e) {
		    $stream = @fopen(APPLICATION_PATH . '/log/database.txt', 'a',
		            false);
		    if (! $stream) {
		        throw new Exception('Failed to open stream');
		    }
		    $writer = new Zend_Log_Writer_Stream($stream);
		    $logger = new Zend_Log($writer);
		    $logger->info($e);
		}
	}
	
	public function loadByOwnerLocation($location, $owner)
	{
	    $select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
	    ->setIntegrityCheck(false);
	    
	    $select->where('location = ?', $location)
	       ->where('owner = ?', $owner);
	    
	  	    
	    $rowSet = $this->getTable()->fetchRow($select);
	    
	    return $rowSet;
	}
	
	/**
	 * 
	 * @param unknown $id
	 * @return Zend_Db_Table_Rowset_Abstract
	 */
	public function loadAllOwnerByLocation($id)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
	
		$select->where('location = ?', $id)
			->joinLeft('owner', "owner_location.owner = owner.id AND owner.status = 1", array('id as owner_id', 'name', 'phone'));
	
		// only fetch first row
		$rowSet = $this->getTable()->fetchAll($select);
	
		return $rowSet;
	}
	
	/**
	 * 
	 * @param int $id
	 * @return Zend_Db_Table_Rowset_Abstract
	 */
	public function loadLocationByOwner($id)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('owner = ?', $id)
			->joinLeft('location', 'owner_location.location = location.id', array('id as location_id', 'street', 'street2', 'city','state', 'zip'));
		
		
		
		$rowSet = $this->getTable()->fetchAll($select);
		
		return $rowSet;
	}
	
	/**
	 *
	 * @param int $id
	 * @return Zend_Db_Table_Rowset_Abstract
	 */
	public function loadSingleLocationByOwner($id)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
	
		$select->where('owner = ?', $id)
		->joinLeft('location', 'owner_location.location = location.id');
	
	
	
		$rowSet = $this->getTable()->fetchRow($select);
	
		return $rowSet;
	}
	
	/**
	 * 
	 * @param unknown $location
	 * @param unknown $owner
	 * @return mixed
	 */
	public function create($location,$owner,$ownerType, $status)
	{
		$data = array(
				'location' => $location,
				'owner' => $owner,
				'owner_type' => $ownerType,
				'status' => $status
				);
				
		$id = $this->getTable()->insert($data);
		
		return $id;
	}
	
	/**
	 * 
	 * @param unknown $ownerId
	 * @param unknown $locationId
	 */
	public function setInactive($ownerId, $locationId)
	{
		$data = array('status' => 0);
		
		$where = "owner = $ownerId and location = $locationId";
		
		
		$this->getTable()->update($data, $where);
	}
	
	/**
	 * 
	 * @param unknown $ownerId
	 * @param unknown $locationId
	 */
	public function setActive($ownerId, $locationId)
	{
		$data = array('status' => 1);
	
		$where = "owner = $ownerId and location = $locationId";
	
	
		$this->getTable()->update($data, $where);
	}
	
	public function update($id, $ownerType, $status) {
		$data = array(
			'owner_type' => $ownerType,
			'status' => $status
		);
		
		$where = $this->getTable()->getDefaultAdapter()->quoteInto('id = ?', $id);
		
		$this->getTable()->update($data, $where);
	}
	
	public function delete($id){
		
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
			$this->_table = new Owner_Model_DbTable_OwnerLocation();
			return $this->_table;
		}
	}
}

