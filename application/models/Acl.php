<?php

class Application_Model_Acl extends Zend_Acl
{
	

	public function __construct()
	{
		
		$this->setRoles();
		$this->setResources();
		
		// admin allow
		$this->allow(Application_Model_Roles::ADMIN,Application_Model_Resources::ADMIN);
		
		// employee allow
		$this->allow(Application_Model_Roles::EMPLOYEE,Application_Model_Resources::VIEW);
		$this->allow(Application_Model_Roles::EMPLOYEE,Application_Model_Resources::ADD);
		$this->allow(Application_Model_Roles::EMPLOYEE,Application_Model_Resources::EDIT);
		$this->allow(Application_Model_Roles::EMPLOYEE,Application_Model_Resources::DELETE);
		
	}
	
	
	public function setRoles()
	{
		$this->addRole(new Zend_Acl_Role(Application_Model_Roles::CLIENT));
		$this->addRole(new Zend_Acl_Role(Application_Model_Roles::EMPLOYEE));
		$this->addRole(new Zend_Acl_Role(Application_Model_Roles::ADMIN), Application_Model_Roles::EMPLOYEE);
	}
	
	public function setResources()
	{
		$this->add(new Zend_Acl_Resource(Application_Model_Resources::ADMIN));
		$this->add(new Zend_Acl_Resource(Application_Model_Resources::VIEW));
		$this->add(new Zend_Acl_Resource(Application_Model_Resources::ADD));
		$this->add(new Zend_Acl_Resource(Application_Model_Resources::EDIT));
		$this->add(new Zend_Acl_Resource(Application_Model_Resources::DELETE));
	}
}

