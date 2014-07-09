<?php

class Well_Model_WellLog
{

	/**
	 *
	 * @var Zend_Db_Table_Abstract
	 */
	protected $_table;
	
	/**
	 * 
	 * @param int $wl_nbr
	 * @param int $well_tag_nbr
	 * @param string $name_last
	 * @param string $name_last
	 * @param string $name_first
	 * @param string $name_company
	 * @param string $street
	 * @param string $city
	 * @param string $state
	 * @param string $zip
	 * @param string $depth_first_water
	 * @param unknown $depth_drilled
	 * @param unknown $completed_depth
	 * @param unknown $completed_depth
	 * @param unknown $post_static_water_level
	 * @param unknown $received_date
	 * @param unknown $use
	 * @param unknown $township
	 * @param unknown $township_char
	 * @param unknown $range
	 * @param unknown $range_char
	 * @param unknown $sctn
	 * @param unknown $qtr160
	 * @param unknown $qtr40
	 * @param unknown $tax_lot
	 * @param unknown $street_of_well
	 * @param unknown $bonded_name_last
	 * @param unknown $bonded_name_first
	 * @param unknown $bonded_name_company
	 * @param unknown $max_yield
	 * @return mixed
	 */
	public function create($wl_county_code,$wl_nbr,$well_tag_nbr,$name_last,$name_first,$name_company,$street,
			$city,$state,$zip,$depth_first_water,$depth_drilled,$completed_depth,$post_static_water_level,
			$received_date,$use,$township,$township_char,$range,$range_char,$sctn,$qtr160,$qtr40,$tax_lot,$street_of_well,
			$bonded_name_last,$bonded_name_first,$bonded_name_company,$max_yield,$longitude,$latitude)
	{
		$data = array(
				'wl_county_code' => $wl_county_code,
				'wl_nbr' => $wl_nbr,
				'well_tag_nbr' => $well_tag_nbr,
				'name_last' => $name_last,
				'name_first' => $name_first,
				'name_company' => $name_company,
				'street' => $street,
				'city' => $city,
				'state' => $state,
				'zip' => $zip,
				'depth_first_water' => $depth_first_water,
				'depth_drilled' => $depth_drilled,
				'completed_depth' => $completed_depth,
				'post_static_water_level' => $post_static_water_level,
				'received_date' => $received_date,
				'use' => $use,
				'township' => $township,
				'township_char' => $township_char,
				'range' => $range,
				'range_char' => $range_char,
				'sctn' => $sctn,
				'qtr160' => $qtr160,
				'qtr40' => $qtr40,
				'tax_lot' => $tax_lot,
				'street_of_well' => $street_of_well,
				'bonded_name_last' => $bonded_name_last,
				'bonded_name_first' => $bonded_name_first,
				'bonded_name_company' => $bonded_name_company,
				'max_yield' => $max_yield,
				'longitude' => $longitude,
				'latitude' => $latitude
				);
		
		//print_r($data);
		
		$id = $this->getTable()->insert($data);
		
		return $id;
	}
	
	public function addLatLon($id,$lat,$lon)
	{
		$data = array(
				'longitude' => $lon,
				'latitude' => $lat,
				);
		$where = $this->getTable()->getDefaultAdapter()->quoteInto('id = ?', $id);
		
		$this->getTable()->update($data, $where);
	}
	
	public function loadAll()
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('latitude < ?',  1);
		
		$rowSet = $this->getTable()->fetchAll($select);
		
		return $rowSet;
	}
	
	/**
	 * 
	 * @param unknown $lat
	 * @param unknown $lon
	 * @param unknown $limit
	 * @return Ambigous <multitype:, multitype:mixed Ambigous <string, boolean, mixed> >
	 */
	public function loadByLatLon($lat,$lon,$limit)
	{
		
		
		$sql =  "SELECT *, ( 3959 * acos( cos( radians($lat) ) * cos( radians( latitude ) ) * cos( radians(  longitude ) - radians($lon) ) + sin( radians($lat) ) * sin( radians( latitude ) ) ) )
			
		AS search_distance FROM well_log where street_of_well !=  '' HAVING search_distance < 25 ORDER BY search_distance LIMIT 0 , $limit";
	
		
		$stmt = $this->getTable()->getDefaultAdapter()->query($sql);
		
		$rowset = $stmt->fetchAll();
		
		return $rowset;
	}
	
	
	/**
	 * 
	 * @param unknown_type $township
	 * @param unknown_type $townshipChar
	 * @param unknown_type $range
	 * @param unknown_type $rangeChar
	 * @param unknown_type $sctn
	 * @param unknown_type $qtr160
	 * @param unknown_type $qtr40
	 */
	public function loadByPlss($township, $townshipChar,$range,$rangeChar,$sctn,$qtr160='',$qtr40='')
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('township = ?', $township)
			->where('township_char = ?', $townshipChar)
			->where('`range` = ?', $range)
			->where('range_char = ?', $rangeChar)
			->where('sctn = ?', $sctn);
			
		if(!empty($qtr160)) {
			$select->where('qtr160 = ?', $qtr160);
		}
		
		if(!empty($qtr40)) {
			$select->where('qtr40 = ?', $qtr40);
		}
		
		
		
		$rowSet = $this->getTable()->fetchRow($select);
		
		return $rowSet;
	}
	
	
	/**
	 * 
	 * @param unknown $street
	 * @return Ambigous <Zend_Db_Table_Row_Abstract, NULL, unknown>
	 */
	public function loadByAddress($street)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('street_of_well LIKE ?', '%'.$street.'%');
		
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
	 */
	public function getTable()
	{
	
		if(null !== $this->_table) {
			return $this->_table;
		} else {
			$this->_table = new Well_Model_DbTable_WellLog();
			return $this->_table;
		}
	}
}

