<?php

class Well_Model_Well
{

	public function loadOldData()
	{
		
		$table = new Well_Model_DbTable_Pumpdata();
			
		$select = $table->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
			->setIntegrityCheck(false);

		$select->order('Record_Id');
		
		$rowSet = $table->fetchAll($select);
		
		return $rowSet;
		
	}
	
	public function loadWelllogs()
	{
		$table = new Well_Model_DbTable_Welllog();
		
		$select = $table->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
			
		$select->limit(10000,3000);
		
		$rowSet = $table->fetchAll($select);
		
		return $rowSet;
		
	}
	
	public function search($search, $field )
	{
	    $table = new Well_Model_DbTable_Pumpdata();
	    
	    $select = $table->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
	    ->setIntegrityCheck(false);
	    
	    switch($field) {
	    	case 'Address':
	           $select->where('Address LIKE ?', '%'.$search.'%');
	        break;
	    }
	    
	    $rowSet = $table->fetchAll($select);
	    
	    return $rowSet;
	    
	}
	
	
	public function loadByid($id)
	{
		$table = new Well_Model_DbTable_Pumpdata();
			
		$select = $table->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('Record_Id = ?', $id);
		
		$rowSet = $table->fetchRow($select);
		
		return $rowSet;
	}
	
	public function loadOldPumpTest()
	{
		$table = new Well_Model_DbTable_Pumptest();
			
		$select = $table->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
			
		$rowSet = $table->fetchAll($select);
		
		return $rowSet;
	}
	
	public function loadPumpTestByOldId($id)
	{
	    $table = new Well_Model_DbTable_Pumptest();
	    	
	    $select = $table->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
	    ->setIntegrityCheck(false);
	    	
	    $select->where('Record_Id = ?', $id);
	    
	    $rowSet = $table->fetchRow($select);
	    
	    return $rowSet;
	}
}

