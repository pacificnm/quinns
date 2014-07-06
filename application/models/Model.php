<?php

/**
 * MyFlix
*
* LICENSE
*
* This source file is subject to the new BSD license that is bundled
* with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://www.pacificnm.com/license/new-bsd
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to pacificnm@gmail.com so we can send you a copy immediately.
*
* @category   Application
* @package    Model
* @copyright  Copyright (c) 2013 Pacific Network Management
* @license    New BSD License
* @version    $Id: Model.php 1.0  Jaimie Garner $
*/
class Application_Model_Model {
	
	/**
	 * Returns the Select Object
	 *
	 * @return Ambigous <Zend_Db_Select, Zend_Db_Table_Select>
	 */
	public function getSelect() {
		$select = $this->getTable ()->select ( Zend_Db_Table::SELECT_WITH_FROM_PART )->setIntegrityCheck ( false );
		
		return $select;
	}
	
	/**
	 * Returns a set of database rows
	 *
	 * @param object $select
	 *        	Zend_Db_Select
	 * @param string $cacheId
	 *        	* @param object $table
	 *        	Zend_Db_Table_Abstract
	 * @throws Zend_Exception
	 * @return Zend_Db_Table_Rowset_Abstract
	 */
	public function getRowSet($select, $table) {
		try {
			$rowSet = $table->fetchAll ( $select );
			
			return $rowSet;
		} catch ( Exception $e ) {
			throw new Zend_Exception ( $e->getMessage () );
		}
	}
	
	/**
	 * Returns a single database row
	 *
	 * @param object $select
	 *        	Zend_Db_Select
	 * @param string $cacheId        	
	 * @param object $table
	 *        	Zend_Db_Table_Abstract
	 * @throws Zend_Exception
	 * @return Zend_Db_Table_Rowset_Abstract
	 */
	public function getRow($select, $table) {
		try {
			$rowSet = $table->fetchRow ( $select );
			
			return $rowSet;
		} catch ( Exception $e ) {
			throw new Zend_Exception ( $e->getMessage () );
		}
	}
	
	/**
	 * Get Paginated Table Rows
	 *
	 * @param int $page        	
	 * @param Object $select
	 *        	Zend_Db_Select
	 * @param string $cacheId        	
	 * @throws Zend_Exception
	 * @return Zend_Paginator
	 */
	public function getPaginator($page, $select) {
		try {
			$paginator = Zend_Paginator::factory ( $select );
			
			$paginator->setItemCountPerPage ( 25 )
			->setPageRange ( 10 )->setCurrentPageNumber ( $page );
			
			return $paginator;
		} catch ( Exception $e ) {
			throw new Zend_Exception ( $e->getMessage () );
		}
	}
}