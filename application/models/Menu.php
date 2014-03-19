<?php

class Application_Model_Menu
{

	/**
	 *
	 * @var Zend_Db_Table_Abstract
	 */
	protected $_table;
	
	public function load()
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->order('order');
		
		$rowset = $this->getTable()->fetchAll($select);
		
		return $rowset;
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
			$this->_table = new Application_Model_DbTable_Menu();
			return $this->_table;
		}
	}

}

