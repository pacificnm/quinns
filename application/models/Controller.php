<?php

class Application_Model_Controller
{

	/**
	 *
	 * @var Zend_Db_Table_Abstract
	 */
	protected $_table;
	
	/**
	 *
	 * @throws Zend_Exception
	 * @return boolean
	 */
	public function __construct()
	{
		$test = new Application_Model_DbTable_Controller();
		if($test->verifyTable() == 'ERROR: Table does not exist') {
			if($test->createTable() == 'OK: Created Table') {
	
				return true;
			} else {
				throw new Zend_Exception('Error checking table password');
			}
		}
	
		return true;
	}
	
	/**
	 *
	 * @param unknown $moduleName
	 * @return Ambigous <Zend_Db_Table_Row_Abstract, NULL, unknown>
	 */
	public function getControllerByName($moduleId, $controllerName)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
	
		$select->where('module_id = ?', $moduleId)
			->where('name = ?', $controllerName);
	
		$rowset = $this->getTable()->fetchRow($select);
	
		return $rowset;
	}
	
	public function loadByModule($moduleId)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('module_id = ?', $moduleId);
		
		$rowset = $this->getTable()->fetchAll($select);
		
		return $rowset;
	}
	
	public function loadById($controllerId)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('controller_id = ?', $controllerId);
		
		$rowset = $this->getTable()->fetchRow($select);
		
		return $rowset;
	}
	
	/**
	 *
	 * @param unknown $moduleId
	 * @param unknown $name
	 * @return Ambigous <mixed, multitype:>
	 */
	public function create($moduleId,$name)
	{
		$data = array(
				'module_id' => $moduleId,
				'name' => $name
		);
		$controllerId = $this->getTable()->insert($data);
	
		return $controllerId;
	}
	
	/**
	 * 
	 * @param unknown $moduleName
	 * @param unknown $controllerName
	 */
	public function writeController($moduleName, $controllerName)
	{
		$class  = new Zend_CodeGenerator_Php_Class();
		
		$docblock = new Zend_CodeGenerator_Php_Docblock(array(
				'shortDescription' => 'Generated Class',
				'longDescription'  => 'This is a class generated with Zend_CodeGenerator.',
				'tags'             => array(
						array(
								'name'        => 'version',
								'description' => '$Rev:$',
						),
						array(
								'name'        => 'license',
								'description' => 'New BSD',
						),
				),
		));
		
		$properties = array(
	        array()
		);
		
		$methods = array(        
	        array(
	            'name'       => 'init',
	            'parameters' => array(),
	            'body'       => '',
	            'docblock'   => new Zend_CodeGenerator_Php_Docblock( 
	            	array( 'shortDescription' => 'Init', 'tags'=> array() ) 
	            )
	         ),
			array(
				'name'       => 'indexAction',
				'parameters' => array(),
				'body'       => '',
				'docblock'   => new Zend_CodeGenerator_Php_Docblock(
					array( 'shortDescription' => 'indexAction', 'tags'=> array() )
				)
			),
		);
		
		$class->setName(ucfirst($moduleName).'_'. ucfirst($controllerName).'Controller')
			->setMethods($methods)
			->setExtendedClass('Zend_Controller_Action');
		
		
		$file = new Zend_CodeGenerator_Php_File(array(
				'classes'  => array($class),
				'docblock' => new Zend_CodeGenerator_Php_Docblock(array(
						'shortDescription' => ucfirst($moduleName) .' Controller class',
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
										'description' => 'Controller',
								),
								array(
										'name'        => 'version',
										'description' => '1.0',
								),
								array(
										'name'        => 'uses',
										'description' => 'Zend_Controller_Action',
								),
						),
				)),
				'body'     => '',
		));
		
		$code = $file->generate();
		
		// check dirs
		$this->createDir($moduleName, $controllerName);
		
		$moduleDir = APPLICATION_PATH . '/modules/' . $moduleName;
		$controllerDir = $moduleDir .'/controllers/';
		$filename = $controllerDir . ucfirst(strtolower($controllerName)) . 'Controller.php';
		
		if(!is_file($filename)) {
			file_put_contents($filename, $code);
		}
	}
	
	public function createDir($moduleName, $controllerName)
	{
		$moduleDir = APPLICATION_PATH . '/modules/' . $moduleName;
		$controllerDir = $moduleDir .'/controllers/';
		
		if(!is_dir($moduleDir)) {
			mkdir($moduleDir);
		}
		
		if(!is_dir($controllerDir)) {
			mkdir($controllerDir);
		}
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
			$this->_table = new Application_Model_DbTable_Controller();
			return $this->_table;
		}
	}
}

