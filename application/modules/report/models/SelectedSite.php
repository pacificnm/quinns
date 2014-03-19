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
 * @category   Report
 * @package    Model
 * @copyright  Copyright (c) Jaimie Garner 2013 I Support Services Inc. (http://www.i-support-services.com)
 * @license    http://www.i-support-services.com/license/new-bsd     New BSD License
 * @version    $Id$
 */
class Report_Model_SelectedSite
{
	/**
	 *
	 * @var Zend_Db_Table_Abstract
	 */
	protected $_table;
	
	/**
	 *
	 * @var Zend_Cache
	 */
	protected $_cache;
	
	/**
	 * loads cache
	 */
	public function __construct()
	{
		$cacheManager =  Zend_Registry::get('cacheMan');
		$this->_cache = $cacheManager->getCache('coreCache');
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
			$this->_table = new Location_Model_DbTable_Location();
			return $this->_table;
		}
	}
}