<?php

class Application_Model_DbTable_Controller extends Zend_Db_Table_Abstract
{

    protected $_name = 'controller';

    const NO_TABLE = 'ERROR: Table does not exist';
    
    const NO_BATABASE = 'ERROR: No database selected';
    
    const ERROR_CREATE = 'ERROR: Cannot create table';
    
    const TABLE_EMPTY = 'WARNING: Table empty';
    
    const CHECK_OK = 'OK: Table passed checks';
    
    const CREATE_OK = 'OK: Created Table';
    
    /**
     *
     * @return string
     */
    public function verifyTable() {
    	try{
    		$db = $this->getDefaultAdapter();
    		if ($db == null) return self::NO_BATABASE;
    	}catch(Exception $e){
    		return self::NO_BATABASE;
    	}
    	try{
    		$result = $db->describeTable('controller'); //throws exception
    		if (empty($result)) return self::NO_TABLE;
    	}catch(Exception $e){
    		return self::NO_TABLE;
    	}
    	$result = $db->fetchRow('SELECT * FROM controller WHERE controller_id = 1');
    	if ($result == null) return self::TABLE_EMPTY;
    	else return self::CHECK_OK;
    }
    
    
    /**
     *
     * @return string
     */
    public function createTable()
    {
    	$db = $this->getDefaultAdapter();
    
    	$sql = '';
    
    	try{
    		$db->query($sql);
    	} catch(Exception $e){
    		return self::ERROR_CREATE;
    	}
    
    	return self::CREATE_OK;
    }
    
    public function defaultValues()
    {
    	$db = $this->getDefaultAdapter();
    	 
    	$sql = '';
    	 
    	try{
    		$db->query($sql);
    	} catch(Exception $e){
    		return self::ERROR_CREATE;
    	}
    	 
    	return self::INSERT_OK;
    }

}

