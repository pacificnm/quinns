<?php

class Application_Model_Action
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
		$test = new Application_Model_DbTable_Action();
		if($test->verifyTable() == 'ERROR: Table does not exist') {
			if($test->createTable() == 'OK: Created Table') {
	
				return true;
			} else {
				throw new Zend_Exception('Error checking table password');
			}
		}
	
		return true;
	}
	
	public function getActionByName($controllerId, $actionName)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('controller_id = ?', $controllerId)
			->where('name = ?', $actionName);
		
		$rowset = $this->getTable()->fetchRow($select);
		
		return $rowset;
	}
	
	/**
	 * 
	 * @param unknown $controllerId
	 * @return Zend_Db_Table_Rowset_Abstract
	 */
	public function loadByController($controllerId)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('controller_id = ?', $controllerId);
		
		$rowset = $this->getTable()->fetchAll($select);
		
		return $rowset;
	}
	
	/**
	 * 
	 * @param unknown $actionId
	 * @return Ambigous <Zend_Db_Table_Row_Abstract, NULL, unknown>
	 */
	public function loadById($actionId)
	{
		$select = $this->getTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
		->setIntegrityCheck(false);
		
		$select->where('action_id = ?', $actionId);
		
		$rowset = $this->getTable()->fetchRow($select);
		
		return $rowset;
	}
	
	public function create($controllerId,$name,$auth,$acl)
	{
		$data = array(
				'controller_id' => $controllerId,
				'name' => $name,
				'auth' => $auth,
				'acl' => $acl
				);
		$actionId = $this->getTable()->insert($data);
		
		return $actionId;
	}
	
	/**
	 * 
	 * @param unknown $actionId
	 * @param unknown $name
	 * @param unknown $auth
	 * @param unknown $acl
	 * @return boolean
	 */
	public function edit($actionId,$name,$auth,$acl,$metaTitle)
	{
		$data = array(
		'name' => $name,
		'auth' => $auth,
		'acl' => $acl,
		'meta_title' => $metaTitle,
		);
		
		$where = $this->getTable()->getDefaultAdapter()->quoteInto('action_id = ?', $actionId);
		
		$this->getTable()->update($data, $where);
		
		return true;
	}
	
	public function writeView($moduleName, $controllerName, $actionName)
	{
		$moduleDir = APPLICATION_PATH . '/modules/' . strtolower($moduleName); 
		$viewDir = $moduleDir . '/views/scripts/' . strtolower($controllerName).'/';
		$actionFile = $viewDir . strtolower($actionName).'.phtml';
		
		if(!is_dir($viewDir)){
			mkdir($viewDir);
		}
		
		$code = '<?php echo $this->MainNav();?>
				<div class="grid_13">
					<div class="box round first fullpage">
					<h2>'.ucfirst($actionName).'</h2>
					<div class="block">
						
					</div>
				</div>
			</div>
			<div class="clear"></div>';
		
		$this->createDir($moduleName, $controllerName, $actionName);
		
		print $actionFile;
		
		if(!is_file($actionFile)) {
			file_put_contents($actionFile, $code);
		}
	}
	
	public function createDir($moduleName, $controllerName, $actionName)
	{
		$moduleDir = APPLICATION_PATH . '/modules/' . strtolower($moduleName);
		$viewDir = $moduleDir . '/views/scripts/' . strtolower($controllerName).'/';
		
		if(!is_dir($moduleDir)) {
			mkdir($moduleDir);
		}
		
		if(!is_dir($moduleDir . '/views')) {
			mkdir($moduleDir . '/views');
		}
		
		if(!is_dir($moduleDir . '/views/scripts/')){
			mkdir($moduleDir . '/views/scripts/');
		}
		
		if(!is_dir($viewDir)) {
			echo 'making' . $viewDir;
			mkdir($viewDir);
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
			$this->_table = new Application_Model_DbTable_Action();
			return $this->_table;
		}
	}
}

