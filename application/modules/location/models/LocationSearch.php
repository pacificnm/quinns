<?php
/**
 * Quinns Well And Pump
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.i-support-services.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@i-support-services.com so we can send you a copy immediately.
 *
 * @category   Location
 * @package    Model
 * @copyright  Copyright (c) Jaimie Garner 2013 I Support Services Inc. (http://www.i-support-services.com)
 * @license    http://www.i-support-services.com/license/new-bsd     New BSD License
 * @version    $Id$
 */
class Location_Model_LocationSearch
{
	/**
	 *
	 * @var Zend_Db_Table_Abstract
	 */
	protected $_table;
	
	
	/**
	 * Creates New Location Search
	 * 
	 * @param int $location
	 * @param string $keyword
	 * @param string $type can be address, plss, or lat
	 * @return int Last Insert ID
	 */
	public function create($location, $keyword, $type)
	{
		$data = array(
				'location' => $location,
				'keyword' => $keyword,
				'type'	=> $type
				);
		
		
		$id = $this->getTable()->insert($data);
		
		return $id;
	}
	
	
	public function loadByLocationType($locationId, $type)
	{
	    $select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
	    ->setIntegrityCheck(false);
	    
	    $select->where('location = ?', $locationId)
	       ->where('type = ?', $type);
	    
	    $rowSet = $this->getTable()->fetchRow($select);
	    
	    return $rowSet;
	}
	
	/**
	 * Loads by keyword
	 * 
	 * @param String $keyword
	 * @param String $type can be address, plss, or lat
	 */
	public function loadByKeyword($keyword,$type)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('keyword LIKE ?', '%'.$keyword . '%')
			->where('type = ?', $type)
			->joinLeft('location', 'location.id = location_search.location')
			->limit(10);
		
		$rowSet = $this->getTable()->fetchAll($select);
		
		return $rowSet->toArray();
	}
	
	/**
	 * Updates Search record by type and location id
	 * 
	 * @param int $locationId
	 * @param string $keyword
	 * @param string $type can be address, plss, or lat
	 */
	public function edit($locationId,$keyword,$type)
	{
		$data = array('keyword' => $keyword);
		
		$where = array('location = ?' => $locationId, 'type = ?' => $type);
		
		$this->getTable()->update($data, $where);
		
	}
	
	/**
	 * Loads the Location Databas Table
	 * 
	 * @return Zend_Db_Table_Abstract
	 */
	public function getTable()
	{
	
		if(null !== $this->_table) {
			return $this->_table;
		} else {
			$this->_table = new Location_Model_DbTable_LocationSearch();
			return $this->_table;
		}
	}

}

