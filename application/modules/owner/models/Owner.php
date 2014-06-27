<?php

class Owner_Model_Owner
{

	/**
	 *
	 * @var Zend_Db_Table_Abstract
	 */
	protected $_table;
	
	/**
	 * 
	 * @param unknown $name
	 * @return Ambigous <Zend_Db_Table_Row_Abstract, NULL, unknown>
	 */
	public function loadByName($name)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('name LIKE ?', $name . '%')->limit(25);
		
		$rowSet = $this->getTable()->fetchAll($select);
		
		return $rowSet;
	}
	
	public function loadAll()
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		
		$rowSet = $this->getTable()->fetchAll($select);
		
		return $rowSet;
	}
	
	public function loadByOldId($oldId)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('old_id =  ?', $oldId);
		
		$rowSet = $this->getTable()->fetchRow($select);
		
		return $rowSet;
	}
	
	/**
	 * 
	 * @param int $id
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
	
	
	public function loadByKeyword($keyword)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
	
		$select->where('name LIKE ?', '%'.$keyword.'%')
		->limit(20);
		
		$rowSet = $this->getTable()->fetchAll($select);
	
		return $rowSet;
	}
	
	/**
	 * 
	 * @param unknown $name
	 * @param unknown $street
	 * @param unknown $street2
	 * @param unknown $city
	 * @param unknown $state
	 * @param unknown $zip
	 * @param unknown $phone
	 * @param unknown $email
	 * @param unknown $status
	 * @return mixed
	 */
	public function create($name,$street,$street2,$city,$state,$zip,$phone,$email,$status,$oldId=0)
	{
		$data = array(
				'name' => $name,
				'street' => $street,
				'street2' => $street2,
				'city' => $city,
				'state' => $state,
				'zip' => $zip,
				'phone' => $phone,
				'email' => $email,
				'status' => $status,
				'old_id' => $oldId,
				
				);
		
		try{
		 $id = $this->getTable()->insert($data);
		
		 return $id;
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
	
	/**
	 * 
	 * @param unknown $id
	 * @param unknown $name
	 * @param unknown $street
	 * @param unknown $street2
	 * @param unknown $city
	 * @param unknown $state
	 * @param unknown $zip
	 * @param unknown $phone
	 * @param unknown $email
	 */
	public function edit($id,$name,$street,$street2,$city,$state,$zip,$phone,$email)
	{
		$data = array(
				'name' => $name,
				'street' => $street,
				'street2' => $street2,
				'city' => $city,
				'state' => $state,
				'zip' => $zip,
				'phone' => $phone,
				'email' => $email,
				);
		$where = $this->getTable()->getDefaultAdapter()->quoteInto('id = ?', $id);
		
		$this->getTable()->update($data, $where);
	}
	
	/**
	 *
	 */
	public function getTable()
	{
	
		if(null !== $this->_table) {
			return $this->_table;
		} else {
			$this->_table = new Owner_Model_DbTable_Owner();
			return $this->_table;
		}
	}
}

