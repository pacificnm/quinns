<?php
class Admin_Form_Element_ActionAcl extends Zend_Form_Element_Select
{
	public function init()
	{
		$this->setLabel('ACL Type:');
		$this->addMultiOption('add', 'Add');
		$this->addMultiOption('admin', 'Admin');
		$this->addMultiOption('delete', 'Delete');
		$this->addMultiOption('edit', 'Edit');
		$this->addMultiOption('view', 'View');
	}
}