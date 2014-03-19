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
class Location_Model_Location
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
    public function __construct ()
    {
        $cacheManager = Zend_Registry::get('cacheMan');
        $this->_cache = $cacheManager->getCache('coreCache');
    }

    /**
     * Loads records by Old Id
     *
     * @param unknown $id            
     * @return Ambigous <Zend_Db_Table_Row_Abstract, NULL, unknown>
     */
    public function loadByOldId ($id)
    {
        $select = $this->getTable()
            ->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
            ->setIntegrityCheck(false);
        
        $select->where('old_id = ?', $id);
        try {
            $rowSet = $this->getTable()->fetchRow($select);
            return $rowSet;
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
     * Loads All Records
     *
     * @return s Zend_Db_Table_Row_Abstract
     */
    public function loadAll ()
    {
        $select = $this->getTable()
            ->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
            ->setIntegrityCheck(false);
        
        $select->order('id');
        
        $rowSet = $this->getTable()->fetchAll($select);
        
        return $rowSet;
    }

    /**
     * Paganated Page to browse locations by
     *
     * @param int $page            
     * @return s Zend_Db_Table_Row_Abstract
     */
    public function browse ($page)
    {
        $select = $this->getTable()
            ->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
            ->setIntegrityCheck(false);
        
        $select->columns(
                array(
                        'id',
                        'street',
                        'city'
                ));
        
        $paginator = Zend_Paginator::factory($select);
        $paginator->setItemCountPerPage(15)
            ->setPageRange(10)
            ->setCurrentPageNumber($page);
        return $paginator;
    }

    /**
     * Loads by location id
     *
     * @param unknown $id            
     * @return Ambigous <Zend_Db_Table_Row_Abstract, NULL, unknown>
     */
    public function loadById ($id)
    {
        $select = $this->getTable()
            ->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
            ->setIntegrityCheck(false);
        
        $select->where('id = ?', $id);
        
        $rowSet = $this->getTable()->fetchRow($select);
        
        return $rowSet;
    }

    /**
     * Loads by an Address
     *
     * @param unknown $address            
     * @return Ambigous <Zend_Db_Table_Row_Abstract, NULL, unknown>
     */
    public function loadByAddress ($address)
    {
        $select = $this->getTable()
            ->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
            ->setIntegrityCheck(false);
        
        $select->where('street LIKE ? ', $address . '%')->limit(30);
        
        $rowSet = $this->getTable()->fetchAll($select);
        
        return $rowSet;
    }

    /**
     * Loads nearby locations based of lat and lon
     *
     * @param string $centerLat            
     * @param string $centerLng            
     * @return Ambigous <Zend_Db_Table_Row_Abstract, NULL, unknown>
     */
    public function loadNearBy ($centerLat, $centerLng)
    {
        $sql = "SELECT *, ( 3959 * acos( cos( radians($centerLat) ) * cos( radians( lat ) ) * cos( radians(  lng ) - radians($centerLng) ) + sin( radians($centerLat) ) * sin( radians( lat ) ) ) )
			
		AS search_distance FROM location HAVING search_distance < 25 ORDER BY search_distance LIMIT 0 , 6";
        
        $stmt = $this->getTable()
            ->getDefaultAdapter()
            ->query($sql);
        
        $rowset = $stmt->fetchAll();
        
        return $rowset;
    }

    /**
     * Creates new Location
     *
     * @param string $street            
     * @param string $street2            
     * @param string $city            
     * @param string $state            
     * @param string $zip            
     * @param int $status            
     * @param int $oldId            
     * @return int
     */
    public function create ($street, $street2, $city, $state, $zip, 
            $billingStreet = null, $billingCity = null, $billingState = null, 
            $billingZip = null, $status=1, $oldId)
    {
        $data = array(
                'street' => $street,
                'street2' => $street2,
                'city' => $city,
                'state' => $state,
                'billing_street' => $billingStreet,
                'billing_city' => $billingCity,
                'billing_state' => $billingState,
                'billing_zip' => $billingZip,
                'zip' => $zip,
                'status' => $status,
                'old_id' => $oldId
        );
        try {
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
     * Updates a location record
     *
     * @param unknown $id            
     * @param unknown $street            
     * @param unknown $street2            
     * @param unknown $city            
     * @param unknown $state            
     * @param unknown $zip            
     * @param unknown $status            
     */
    public function edit ($id, $street, $street2, $city, $state, $zip, $status)
    {
        $data = array(
                'street' => $street,
                'street2' => $street2,
                'city' => $city,
                'state' => $state,
                'zip' => $zip,
                'status' => $status
        );
        
        $where = $this->getTable()
            ->getDefaultAdapter()
            ->quoteInto('id = ?', $id);
        
        $this->getTable()->update($data, $where);
    }

    /**
     * Adds Lat and Lon to Location
     *
     * @param int $id            
     * @param string $lat            
     * @param string $lng            
     */
    public function addLatLng ($id, $lat, $lng)
    {
        $data = array(
                'lat' => $lat,
                'lng' => $lng
        );
        
        $where = $this->getTable()
            ->getDefaultAdapter()
            ->quoteInto('id = ?', $id);
        
        $this->getTable()->update($data, $where);
    }

    /**
     * Adds PLSS Data
     *
     * @param int $id            
     * @param string $township            
     * @param string $townshipChar            
     * @param string $rang            
     * @param string $rangChar            
     * @param string $section            
     * @param string $division            
     */
    public function addPlls ($id, $township, $townshipChar, $rang, $rangChar, 
            $section, $division)
    {
        $data = array(
                'township' => $township,
                'township_char' => $townshipChar,
                'range' => $rang,
                'range_char' => $rangChar,
                'sctn' => $section,
                'division' => $division
        );
        $where = $this->getTable()
            ->getDefaultAdapter()
            ->quoteInto('id = ?', $id);
        
        $this->getTable()->update($data, $where);
    }

    /**
     * Loads all cities
     *
     * @return Ambigous <Zend_Db_Table_Row_Abstract, NULL, unknown>
     */
    public function loadCity ()
    {
        $select = $this->getTable()
            ->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
            ->setIntegrityCheck(false);
        
        $select->where('state = ?', 'Or')
            ->group('city')
            ->order('city');
        
        $rowSet = $this->getTable()->fetchAll($select);
        
        return $rowSet;
    }

    /**
     * Loads the Location Databas Table
     *
     * @return Zend_Db_Table_Abstract
     */
    public function getTable ()
    {
        if (null !== $this->_table) {
            return $this->_table;
        } else {
            $this->_table = new Location_Model_DbTable_Location();
            return $this->_table;
        }
    }
}

