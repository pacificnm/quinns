<?php

class Owner_Form_Edit extends Zend_Form
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
    }

    public function owner($owner)
    {
    	$element = new Owner_Form_Element_Name('name');
    	$element->setValue($owner->name);
    	$this->addElement($element);
    	
    	$element = new Owner_Form_Element_Phone('phone');
    	$element->setValue($owner->phone);
    	$this->addElement($element);
    	 
    	$element = new Owner_Form_Element_Email('email');
    	$element->setValue($owner->email);
    	$this->addElement($element);
    	
    	$element = new Owner_Form_Element_Street('street');
    	$element->setValue($owner->street);
    	$this->addElement($element);
    	
    	$element = new Owner_Form_Element_Street2('street2');
    	$element->setValue($owner->street2);
    	$this->addElement($element);
    	
    	$element = new Owner_Form_Element_City('city');
    	$element->setValue($owner->city);
    	$this->addElement($element);
    	
    	$element = new Owner_Form_Element_State('state');
    	$element->setValue($owner->state);
    	$this->addElement($element);
    	
    	$element = new Owner_Form_Element_Zip('zip');
    	$element->setValue($owner->zip);
    	$this->addElement($element);
    	
    	$this->addElement('hash', 'no_csrf', array('salt' => 'unique', 'timeout' => 3600));
    	 
    	$this->addElement(new Application_Form_Element_Submit('submit'));
    	 
    	return $this;
    }
    
    public function location($data)
    {
    	$element = new Owner_Form_Element_Type('owner_type');
    	$element->setValue($data->owner_type);
    	$this->addElement($element);
    	
    	$element = new Owner_Form_Element_Status('status');
    	$element->setValue($data->status);
    	$this->addElement($element);
    	
    	$this->addElement(new Application_Form_Element_Submit('submit'));
    	
    	$this->addElement('hash', 'no_csrf', array('salt' => 'unique', 'timeout' => 3600));
    	
    	return $this;
    }
    
    

}

