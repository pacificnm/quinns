<?php

class SelectedSite_Model_SelectedSiteData
{

	/**
	 *
	 * @var Zend_Db_Table_Abstract
	 */
	protected $_table;
	
	
	/**
	 * 
	 * @param unknown_type $selectedSiteId
	 * @param unknown_type $wellLogId
	 * @param unknown_type $searchDistance
	 */
	public function create($selectedSiteId, $wellLogId, $searchDistance)
	{
		$data = array(
				'selected_site_id' 	=> $selectedSiteId,
				'well_log_id' 		=> $wellLogId,
				'distance'   => $searchDistance
				);
		$id = $this->getTable()->insert($data);
		
		return $id;
	}
	
	public function loadBySelectedSiteId($id)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('selected_site_id = ?', $id)
			->joinLeft('well_log', 'well_log.id = selected_site_data.well_log_id');
		
		$rowSet = $this->getTable()->fetchAll($select);
		
		return $rowSet;
	}
	
	/**
	 * 
	 * @param unknown_type $id
	 */
	public function removeBySelectedSite($id)
	{
		$where = $this->getTable()->getDefaultAdapter()->quoteInto('selected_site_id = ?', $id);
		
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
			$this->_table = new SelectedSite_Model_DbTable_SelectedSiteData();
			return $this->_table;
		}
	}
}

