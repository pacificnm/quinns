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
 * @category   City
 * @package    Model
 * @copyright  Copyright (c) Jaimie Garner 2013 I Support Services Inc. (http://www.i-support-services.com)
 * @license    http://www.i-support-services.com/license/new-bsd     New BSD License
 * @version    $Id$
 */
class City_Model_City
{
	/**
	 *
	 * @var Zend_Db_Table_Abstract
	 */
	protected $_table;
	
	/**
	 * 
	 * @param unknown $value
	 * @return mixed
	 */
	public function create($value)
	{
		$data = array(
				'value' => $value
				);
		
		$id = $this->getTable()->insert($data);
		
		return $id;
	}
	
	/**
	 * 
	 * @param unknown $id
	 * @param unknown $value
	 */
	public function edit($id,$value)
	{
		$data = array(
			'value' => $value
		);
		
		$where = $this->getTable()->getDefaultAdapter()->quoteInto('id = ?', $id);
		
		$this->getTable()->update($data, $where);
	}
	
	/**
	 * 
	 * @param unknown $id
	 */
	public function remove($id)
	{
		$where = $this->getTable()->getDefaultAdapter()->quoteInto('id = ?', $id);
		
		$this->getTable()->delete($where);
	}
	
	/**
	 * 
	 * @param unknown $value
	 * @return Ambigous <Zend_Db_Table_Row_Abstract, NULL, unknown>
	 */
	public function loadByValue($value)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('value= ?', $value);
		
		$rowSet = $this->getTable()->fetchRow($select);
		
		return $rowSet;
	}
	
	/**
	 * 
	 * @return Zend_Db_Table_Rowset_Abstract
	 */
	public function loadAll()
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$rowSet = $this->getTable()->fetchAll($select);
		
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
	 * @param unknown $value
	 */
	public function checkValue($value)
	{
		$city = $this->loadByValue($value);
	
		if(empty($city)) {
			$this->create($value);
		}
	}
	/**
	 *
	 * @param unknown $keyword
	 * @return multitype:
	 */
	public function loadByKeyword($keyword)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
	
		$select->where('value LIKE ?', '%'.$keyword.'%')
		->limit(20);
	
		$rowSet = $this->getTable()->fetchAll($select);
	
		return $rowSet->toArray();
	}
	
	
	/**
	 *
	 */
	public function getTable()
	{
	
		if(null !== $this->_table) {
			return $this->_table;
		} else {
			$this->_table = new City_Model_DbTable_City();
			return $this->_table;
		}
	}

}

