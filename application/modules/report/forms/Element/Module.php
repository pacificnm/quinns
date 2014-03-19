<?php 
class Report_Form_Element_Module extends Zend_Form_Element_Select
{
	public function init()
	{
		$this->setLabel('Module:');
		$this->addMultiOption('', 'All');
		
		$moduleClass = new Application_Model_Module();
		
		$modules = $moduleClass->loadAll();
		
		foreach($modules as $module){
			$this->addMultiOption($module->name, $module->name);
		}
	}
}