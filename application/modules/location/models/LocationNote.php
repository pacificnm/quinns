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
class Location_Model_LocationNote
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
		
		$select->where('location = ?', $location);
		
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
	 * @param unknown $directions
	 * @param unknown $note
	 * @param unknown $access
	 * @param unknown $boomTruck
	 * @param unknown $dog
	 * @param unknown $men
	 */
	public function create($locationId,$directions,$note,$access,$boomTruck,$dog,$men,$explanation,$oldid = null)
	{
		$data = array(
			'location' => $locationId,
			'directions' => $directions,
			'note' => $note,
			'access' => $access,
			'boom_truck' => $boomTruck,
			'dog' => $dog,	
			'men' => $men,
			'explanation' => $explanation,
		    'old_id' => $oldid
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
	 * @param unknown $directions
	 * @param unknown $note
	 * @param unknown $access
	 * @param unknown $boomTruck
	 * @param unknown $dog
	 * @param unknown $men
	 * @param unknown $explanation
	 */
	public function edit($id,$directions,$note,$access,$boomTruck,$dog,$men,$explanation)
	{
		$data = array(
				'directions' => $directions,
				'note' => $note,
				'access' => $access,
				'boom_truck' => $boomTruck,
				'dog' => $dog,
				'men' => $men,
				'explanation' => $explanation
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
			$this->_table = new Location_Model_DbTable_LocationNote();
			return $this->_table;
		}
	}
}

