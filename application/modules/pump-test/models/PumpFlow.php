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
 * @category   PumpTest
 * @package    Model
 * @copyright  Copyright (c) Jaimie Garner 2013 I Support Services Inc. (http://www.i-support-services.com)
 * @license    http://www.i-support-services.com/license/new-bsd     New BSD License
 * @version    $Id$
 */
class PumpTest_Model_PumpFlow
{

	/**
	 *
	 * @var Zend_Db_Table_Abstract
	 */
	protected $_table;
	
	/**
	 * 
	 * @param unknown $pumpTest
	 * @param unknown $flow
	 * @param unknown $static
	 * @param unknown $time
	 * @return multitype:unknown
	 */
	public function create($pumpTest,$flow,$static,$time)
	{
		$data = array(
				'pump_test' => $pumpTest,
				'flow' => $flow,
				'static' => $static,
				'time' => $time
				);
		
		$id = $this->getTable()->insert($data);
		
		return $data;
	}
	
	/**
	 * 
	 * @param unknown $id
	 * @return Zend_Db_Table_Rowset_Abstract
	 */
	public function loadByTest($id)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('pump_test = ?', $id);
		
		$rowSet = $this->getTable()->fetchAll($select);
		
		return $rowSet;
	}
	
	/**
	 * 
	 * @param unknown $id
	 * @param unknown $flow
	 * @param unknown $static
	 */
	public function edit($id,$flow,$static)
	{
		$data = array(
				'flow' => $flow,
				'static' => $static,
				);
		$where = $this->getTable()->getDefaultAdapter()->quoteInto('id = ?', $id);
	
		
		$this->getTable()->update($data, $where);
	}
	
	/**
	 * 
	 * @param unknown $pumptestId
	 */
	public function delete($pumptestId)
	{
	    $where = $this->getTable()->getDefaultAdapter()->quoteInto('pump_test = ?', $pumptestId);
	   	    
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
			$this->_table = new PumpTest_Model_DbTable_PumpFlow();
			return $this->_table;
		}
	}
}

