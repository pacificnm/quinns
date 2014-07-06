<?php

class Pump_Model_Pump
{

	/**
	 *
	 * @var Zend_Db_Table_Abstract
	 */
	protected $_table;
	
	public function loadOldPumpData()
	{
		$table = new Pump_Model_DbTable_Pumptable();
		
		$select = $table->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
	
		
		$rowSet = $table->fetchAll($select);
		
		return $rowSet;
	}
	
	public function loadAll()
	{
	    $select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
	    ->setIntegrityCheck(false);
	    
	    $rowSet = $this->getTable()->fetchAll();
	    
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
		
		$select->where('pump.id = ?', $id)
			->joinLeft('tank', 'tank.id = pump.id', array('id as tank_id', 'size', 'type', 'model', 'filtration'));
		
		$rowSet = $this->getTable()->fetchRow($select);
		
		return $rowSet;
	}
	
	
	
	/**
	 * 
	 * @param unknown $location
	 * @return Zend_Db_Table_Rowset_Abstract
	 */
	public function loadByLocation($location)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('pump.location 	 = ?', $location)
			->joinLeft('pump_test', 'pump.id = pump_test.pump','pump_test.id as pump_test_id')
			->joinLeft('tank', 'tank.id = pump.id', array('id as tank_id', 'size', 'type', 'model', 'filtration'));
		
		$rowSet = $this->getTable()->fetchAll($select);
		
		return $rowSet;
	}
	
	
	public function loadByOldId($oldId)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('old_id = ?', $oldId);
		
		
		
		$rowSet = $this->getTable()->fetchRow($select);
		
		return $rowSet;
	}
	
	public function orderByPipe()
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->group('pipe');
		
		echo $select->__toString();
		$rowSet = $this->getTable()->fetchAll($select);
		
		return $rowSet;
	}
	
	/**
	 * 
	 * @param unknown $location
	 * @param unknown $pumpModel
	 * @param unknown $pumpType
	 * @param unknown $voltage
	 * @param unknown $phase
	 * @param unknown $wire
	 * @param unknown $pipe
	 * @param unknown $pipeSize
	 * @param unknown $wellDepth
	 * @param unknown $pumpDepth
	 * @param unknown $status
	 * @return mixed
	 */
	public function create($location,$pumpModel,$pumpType,$voltage,
			$phase,$wire,$pipe,$pipeSize,$wellDepth,$pumpDepth,$use,$yield,$pumpTag,$staticLevel,$status,$oldId=0)
	{
		$data = array(
				'location' => $location,
				'pump_model' => $pumpModel,
				'pump_type' => $pumpType,
				'voltage' => $voltage,
				'phase' => $phase,
				'wire' => $wire,
				'pipe' => $pipe,
				'pipe_size' => $pipeSize,
				'well_depth' => $wellDepth,
				'pump_depth' => $pumpDepth,
				'use' => $use,
				'yield' => $yield,
				'pump_tag' => $pumpTag,
				'static_level' => $staticLevel,
				'status' => $status,
				'old_id' =>$oldId,
				
				);
		
		$id = $this->getTable()->insert($data);
		
		return $id;
	}
	
	/**
	 * 
	 * @param unknown $id
	 * @param unknown $pumpModel
	 * @param unknown $pumpType
	 * @param unknown $voltage
	 * @param unknown $phase
	 * @param unknown $wire
	 * @param unknown $pipe
	 * @param unknown $pipeSize
	 * @param unknown $wellDepth
	 * @param unknown $pumpDepth
	 * @param unknown $status
	 */
	public function edit($id,$pumpModel,$pumpType,$voltage,$phase,$wire,$pipe,$pipeSize,
			$wellDepth,$pumpDepth,$pumpTag,$use,$yield,$staticLevel,$status)
	{
		$data = array(
				'pump_model' => $pumpModel,
				'pump_type' => $pumpType,
				'voltage' => $voltage,
				'phase' => $phase,
				'wire' => $wire,
				'pipe' => $pipe,
				'pipe_size' => $pipeSize,
				'well_depth' => $wellDepth,
				'pump_depth' => $pumpDepth,
				'use' => $use,
				'yield' => $yield,
				'pump_tag' => $pumpTag,
				'static_level' => $staticLevel,
				'status' => $status
				);
		$where = $this->getTable()->getDefaultAdapter()->quoteInto('id = ?', $id);
		
		$this->getTable()->update($data, $where);
	}
	
	public function delete($pumpId)
	{
	    $adapter = $this->getTable()->getDefaultAdapter();
	    
	    $where = $adapter->quoteInto('id = ?', $pumpId);
	    
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
			$this->_table = new Pump_Model_DbTable_Pump();
			return $this->_table;
		}
	}
}

