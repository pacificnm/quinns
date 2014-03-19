<?php

class Application_Model_Module
{

	/**
	 *
	 * @var Zend_Db_Table_Abstract
	 */
	protected $_table;
	
	/**
	 * 
	 * @param unknown $moduleName
	 * @return Ambigous <Zend_Db_Table_Row_Abstract, NULL, unknown>
	 */
	public function getModuleByName($moduleName)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('name = ?', $moduleName);
		
		$rowset = $this->getTable()->fetchRow($select);
		
		return $rowset;
	}
	
	public function loadAll()
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);

		$select->order('name');
		
		$rowset = $this->getTable()->fetchAll($select);
		
		return $rowset;
		
	}
	
	public function loadById($moduleId)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('module_id = ?', $moduleId);
		
		$rowset = $this->getTable()->fetchRow($select);
		
		return $rowset;
	}
	
	public function create($moduleName)
	{
		$data = array(
			'name' =>$moduleName,
			'status' => 1
				);
		$moduleId = $this->getTable()->insert($data);
		
		return $moduleId;
	}
	
	/**
	 * 
	 * @param unknown $moduleName
	 */
	public function writeBootstrap($moduleName)
	{
		$class  = new Zend_CodeGenerator_Php_Class();
		
		$moduleName = strtolower($moduleName);
		
		$class->setName(ucfirst($moduleName).'_Bootstrap')
		->setExtendedClass('Zend_Application_Module_Bootstrap');
	
		  $file = new Zend_CodeGenerator_Php_File(array(
	        'classes'  => array($class),
	        'docblock' => new Zend_CodeGenerator_Php_Docblock(array(
	            'shortDescription' => ucfirst($moduleName) .' Bootstrap class to bootstrap model',
	            'tags'             => array(
	            	array(
	            		'name'        => 'author',
	            		'description' => 'ISS Jaimie Garner',
	            	),
	            	array(
	            		'name'        => 'copyright',
	            		'description' => date("Y", time()),
	            	),
	                array(
	                    'name'        => 'package',
	                    'description' => ucfirst($moduleName),
	                ),
	            	array(
	            		'name'        => 'category',
	            		'description' => 'Bootstrap',
	            	),
	            	array(
	            		'name'        => 'version',
	            		'description' => '1.0',
	            	),
	            	array(
	            		'name'        => 'uses',
	            		'description' => 'Zend_Application_Module_Bootstrap',
	            	),
	            ),
	        )),
	        'body'     => '',
	    )); 
		
		$code = $file->generate();
		
		$moduleDir = APPLICATION_PATH . '/modules/' . $moduleName;
		file_put_contents($moduleDir . '/Bootstrap.php', $code);
	}
	
	/**
	 * 
	 * @param unknown $name
	 * @return string
	 */
	public function createModuleDir($name)
	{
		$moduleName = strtolower($name);
		
		$moduleDir = APPLICATION_PATH . '/modules/' . $moduleName;
		$controllerDir = $moduleDir . '/controllers';
		$formDir = $moduleDir . '/forms';
		$langDir = $moduleDir .'/languages';
		$modelsDir = $moduleDir . '/models';
		$viewsDir = $moduleDir . '/views';
		$dbTableDir = $modelsDir .'/DbTable';
		$elementDir = $formDir .'/Element';
		$filtersDir = $viewsDir .'/filters';
		$helpersDir = $viewsDir . '/helpers';
		$scriptsDir = $viewsDir . '/scripts';
		
		
		if(!is_dir($moduleDir)) {
			mkdir($moduleDir);
		}
		
		if(!is_dir($controllerDir)){
			mkdir($controllerDir);
		}
		
		if(!is_dir($formDir)){
			mkdir($formDir);
		}
		
		if(!is_dir($langDir)){
			mkdir($langDir);
		}
		
		if(!is_dir($modelsDir)){
			mkdir($modelsDir);
		}
		
		if(!is_dir($viewsDir)){
			mkdir($viewsDir);
		}
		if(!is_dir($dbTableDir)){
			mkdir($dbTableDir);
		}
		
		if(!is_dir($elementDir)){
			mkdir($elementDir);
		}
		
		if(!is_dir($filtersDir)){
			mkdir($filtersDir);
		}
		
		if(!is_dir($helpersDir)){
			mkdir($helpersDir);
		}
		if(!is_dir($scriptsDir)){
			mkdir($scriptsDir);
		}
		return $moduleDir;
	}
	
	/**
	 *
	 * @return Zend_Db_Table_Abstract
	 */
	public function getTable()
	{
	
		if(null !== $this->_table) {
			return $this->_table;
		} else {
			$this->_table = new Application_Model_DbTable_Module();
			return $this->_table;
		}
	}
}

