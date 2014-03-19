<?php

class SelectedSite_Model_SelectedSite
{

	/**
	 *
	 * @var Zend_Db_Table_Abstract
	 */
	protected $_table;
	
	/**
	 * 
	 * @param unknown_type $owner
	 * @param unknown_type $employee
	 * @param unknown_type $date
	 */
	public function create($owner,$employee,$date,$search)
	{
		$data = array(
				'owner' 	=> $owner,
				'employee' 	=> $employee,
				'date' 		=> $date,
				'search'	=> $search
				);
		$id = $this->getTable()->insert($data);
		
		return $id;
	}
	
	/**
	 * Loads All Selected Sites Reports and returns them ordered by Date
	 */
	public function loadAll()
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select
			->joinLeft('owner', 'selected_site.owner = owner.id', array('id as owner_id', 'name'))
			->order('selected_site.date DESC');
	
		
		$rowSet = $this->getTable()->fetchAll($select);
		
		return $rowSet;
	}
	
	/**
	 * 
	 * @param unknown_type $id
	 */
	public function loadById($id)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('selected_site.id = ?', $id)
			->joinLeft('owner', 'selected_site.owner = owner.id', array('owner.id as owner_id', 'name','street','city','state','zip','phone','email'))
			->joinLeft('employee', 'selected_site.employee = employee.employee_id', array('employee_id', 'first_name', 'last_name'));
	
		$rowSet = $this->getTable()->fetchRow($select);
		
		return $rowSet;
	}
	
	/**
	 * Removes selected site report and selected site data by id
	 * 
	 * @param int $id the selected site report id
	 * @return void
	 */
	public function remove($id)
	{
		$where = $this->getTable()->getDefaultAdapter()->quoteInto("id = ?", $id);
		
		$this->getTable()->delete($where);
		
		$selectedSiteDateModel = new SelectedSite_Model_SelectedSiteData();
		$selectedSiteDateModel->loadBySelectedSiteId($id);
		
	}
	
	/**
	 *
	 */
	public function getTable()
	{
	
		if(null !== $this->_table) {
			return $this->_table;
		} else {
			$this->_table = new SelectedSite_Model_DbTable_SelectedSite();
			return $this->_table;
		}
	}
}

