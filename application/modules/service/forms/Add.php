<?php

class Service_Form_Add extends Zend_Form
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
    
    public function service($owners, $pumps)
    {
        
        
    	$this->addElement(new Service_Form_Element_Employee('employee'));
    	
    	$element = new Service_Form_Element_Date('date');
    	$element->setValue(date('M d, Y', time()));
    	$this->addElement($element);
    	
    	// set owners
    	$element = new Service_Form_Element_Owner('owner_id');
    	foreach($owners as $owner) {
    		$element->addMultiOption($owner->owner_id, $owner->name . " - " . $owner->owner_type);
    	}
    	$element->setDescription('The Contact selected will be the Billing Address. All other Contacts will be included in the Service Request.');
    	$this->addElement($element);
    	
    	$element = new Service_Form_Element_Pump('pump');
    	
    	foreach($pumps as $pump) {
    		$element->addMultiOption($pump->id, $pump->pump_model);
    	}
    	$element->addMultiOption('0', 'Unknown');
    	$this->addElement($element);
    	
    	$element = new Service_Form_Element_StartTime('startTime');
    	$element->setLabel('Start Time:');
    	$this->addElement($element);
    	
    	$element = new Service_Form_Element_EndTime('endTime');
    	$element->setLabel('End Time:');
    	$this->addElement($element);
    	
    	$this->addElement(new Service_Form_Element_Complaint('complaint'));
    	
    	$this->addElement(new Service_Form_Element_Description('description'));
    	
    	$this->addElement(new Service_Form_Element_Directions('directions'));
    	
    	$this->addElement(new Service_Form_Element_Status('status'));
    	
    	$this->addElement(new Service_Form_Element_FlowTest('flow_test'));
    	
    	$this->addElement('hash', 'no_csrf', array('salt' => 'unique', 'timeout' => 3600));
    	
    	$this->addElement(new Application_Form_Element_Submit('submit'));
    	
    	return $this;
    }

    

}

