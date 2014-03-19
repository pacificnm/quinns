<?php

class Employee_Form_Admin extends Zend_Form
{

	public function __construct()
	{
		// this is where i normally set up my decorators for the form and elements
		// additionally you can register prefix paths for custom validators, decorators, and elements
	
		parent::__construct();
		// parent::__construct must be called last because it calls $form->init()
		// and anything after it is not executed
	}
	
	public function highlightErrorElements()
	{
	
		foreach($this->getElements() as $element) {
			if($element->hasErrors()) {
	
				$glass  = $element->getAttrib('class');
	
				$element->setDecorators(array(
						'ViewHelper',
						'Description',
						array('HtmlTag', array('tag' => 'div')),
						array('Label', array('tag' => 'div', 'class' => 'error')),
				));
				$element->setAttrib('class', $glass . ' error');
			}
		}
	
	
		$this->setDecorators(array(
				'ViewHelper',
				'Description',
				array('HtmlTag', array('tag' => 'div')),
				array('Label', array('tag' => 'div')),
		));
	}
	
    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->addElement('hash', 'no_csrf', array('salt' => 'unique'));
        	
        $this->addElement(new Application_Form_Element_Submit('submit'));
    }
    
    public function add()
    {
        $element = new Employee_Form_Element_FirstName('first_name');
    	$this->addElement($element);
    
    	$element = new Employee_Form_Element_LastName('last_name');
    	$this->addElement($element);
    
    	$element = new Employee_Form_Element_Email('email');
    	$this->addElement($element);
    
    	$element = new Employee_Form_Element_WorkPhone('work_phone');
    	$this->addElement($element);
    
    	$element = new Employee_Form_Element_MobilePhone('mobile_phone');
    	$this->addElement($element);
    
    	$element = new Employee_Form_Element_HomePhone('home_phone');
    	$this->addElement($element);
    
    	$element = new Employee_Form_Element_JobTitle('job_title');
    	$this->addElement($element);
    
    	$element = new Employee_Form_Element_Address('address');
   
    	$this->addElement($element);
    
    	$element = new Employee_Form_Element_Im('im');
    	$this->addElement($element);
    
    	$element = new Employee_Form_Element_Vehicle('vehicle');
    	$this->addElement($element);
    
    	$element = new Employee_Form_Element_Password('password');
    	$this->addElement($element);
    	
    	$element = new Employee_Form_Element_Acl('acl');
    	$this->addElement($element);
    	 
    	$element = new Employee_Form_Element_Status('status');
    	$this->addElement($element);
    	 
    	
    	return $this;
    }

	public function search($status)
	{
		
		
		$element = new Employee_Form_Element_Status('status');
		$element->setValue($status);
		$this->addElement( $element);
		
		
		$this->addElement('hash', 'no_csrf', array('salt' => 'unique'));
			
		$this->addElement(new Application_Form_Element_Search('submit'));
		
		return $this;
	}
	
	public function edit($employee)
	{
	    $element = new Employee_Form_Element_FirstName('first_name');
	    $element->setValue($employee->first_name);
	    $this->addElement($element);
	    
	    $element = new Employee_Form_Element_LastName('last_name');
	    $element->setValue($employee->last_name);
	    $this->addElement($element);
	    
	    $element = new Employee_Form_Element_Email('email');
	    $element->setValue($employee->email);
	    $this->addElement($element);
	    
	    $element = new Employee_Form_Element_WorkPhone('work_phone');
	    $element->setValue($employee->work_phone);
	    $this->addElement($element);
	    
	    $element = new Employee_Form_Element_MobilePhone('mobile_phone');
	    $element->setValue($employee->mobile_phone);
	    $this->addElement($element);
	    
	    $element = new Employee_Form_Element_HomePhone('home_phone');
	    $element->setValue($employee->home_phone);
	    $this->addElement($element);
	    
	    $element = new Employee_Form_Element_JobTitle('job_title');
	    $element->setValue($employee->job_title);
	    $this->addElement($element);
	    
	    $element = new Employee_Form_Element_Address('address');
	    $element->setValue($employee->address);
	    $this->addElement($element);
	    
	    $element = new Employee_Form_Element_Im('im');
	    $element->setValue($employee->im);
	    $this->addElement($element);
	    
	    $element = new Employee_Form_Element_Vehicle('vehicle');
	    $element->setValue($employee->vehicle);
	    $this->addElement($element);
	    
	    $element = new Employee_Form_Element_Password('password');
	    $element->setValue($employee->password);
	    $this->addElement($element);
	    
	    $element = new Employee_Form_Element_Acl('acl');
	    $element->setValue($employee->acl);
	    $this->addElement($element);
	    
	    $element = new Employee_Form_Element_Status('status');
	    $element->setValue($employee->status);
	    $this->addElement($element);
	    
	    return $this;
	}
	
	public function delete()
	{
		$this->addElement('hash', 'no_csrf', array('salt' => 'unique'));
		$this->addElement(new Application_Form_Element_Delete('submit'));
		
		return $this;
	}
}

