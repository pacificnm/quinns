<?php

class Employee_Form_Add extends Zend_Form
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
    	$this->addElement(new Employee_Form_Element_FirstName('first_name'));
    	
    	$this->addElement(new Employee_Form_Element_LastName('last_name'));
    	
    	$this->addElement(new Employee_Form_Element_Email('email'));
    	
    	$this->addElement(new Employee_Form_Element_Password('password'));
    	
        $this->addElement(new Employee_Form_Element_Submit('submit'));
    }

    public function add()
    {
        $this->addElement(new Employee_Form_Element_FirstName('first_name'));
         
        $this->addElement(new Employee_Form_Element_LastName('last_name'));
         
        $this->addElement(new Employee_Form_Element_Email('email'));
         
        $this->addElement(new Employee_Form_Element_Password('password'));
         
        $this->addElement(new Employee_Form_Element_Submit('submit'));
    }

}

