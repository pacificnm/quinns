<?php

class Geo_Model_Geo
{

	/**
	 *
	 * @var Zend_Db_Table_Abstract
	 */
	protected $_table;
	
	/**
	 * 
	 * @param unknown $location
	 * @return Ambigous <Zend_Db_Table_Row_Abstract, NULL, unknown>
	 */
	public function loadByLocation($location)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('geo.location = ?', $location)
			->joinLeft('location', 'location.id = geo.location');
		//echo $select->__toString();
		$rowSet = $this->getTable()->fetchRow($select);
		
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
		
		$select->where('id = ?', $id);
		
		$rowSet = $this->getTable()->fetchRow($select);
		
		return $rowSet;
	}
	
	/**
	 * 
	 * @param unknown $location
	 * @param unknown $lat
	 * @param unknown $lon
	 * @param unknown $twn
	 * @param unknown $rng
	 * @param unknown $char
	 * @param unknown $sec
	 * @param unknown $qs
	 * @param unknown $qq
	 * @param unknown $taxLot
	 * @return mixed
	 */
	public function create($location,$distance,$duration,$directions)
	{
		$data = array(
				'location' => $location,
				'distance' => $distance,
				'duration' => $duration,
				'directions' => $directions
				);
		$id = $this->getTable()->insert($data);
		
		return $id;
	}
	
	
	public function getNearby($centerLat,$centerLng)
	{
		$sql =  "SELECT *, ( 3959 * acos( cos( radians($centerLat) ) * cos( radians( lat ) ) * cos( radians(  lon ) - radians($centerLng) ) + sin( radians($centerLat) ) * sin( radians( lat ) ) ) ) 
			
		AS search_distance FROM geo LEFT JOIN `location` ON location.id = geo.location HAVING search_distance < 25 ORDER BY search_distance LIMIT 0 , 6";
		
		$stmt = $this->getTable()->getDefaultAdapter()->query($sql);
		
		$rowset = $stmt->fetchAll();
		
		return $rowset;
	}
	
	public function edit($id,$lat,$lon,$distance,$duration,$directions)
	{
		$data = array(
				'lat' => $lat,
				'lon' => $lon,
				'distance' => $distance,
				'duration' => $duration,
				'directions' => $directions,
				
				);
		$where = $this->getTable()->getDefaultAdapter()->quoteInto('location = ?', $id);
		
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
			$this->_table = new Geo_Model_DbTable_Geo();
			return $this->_table;
		}
	}
}

