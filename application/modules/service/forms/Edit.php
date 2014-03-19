<?php

class Service_Form_Edit extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
    }

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
    
    /**
     * 
     * @param unknown $service
     * @return Service_Form_Edit
     */
    public function service($service, $owner, $pumps)
    {
    	
    	$element = new Service_Form_Element_Employee('employee');
    	$element->setValue($service->employee);
    	$this->addElement($element);
    	
    	$element = new Service_Form_Element_Date('date');
    	$element->setValue(date('M d,Y', $service->date));
    	$this->addElement($element);
    	
    	$element = new Service_Form_Element_Owner('owner');
    	$element->setValue($owner->name);
    	$this->addElement($element);
    	
    	$element = new Service_Form_Element_Complaint('complaint');
    	$element->setValue($service->complaint);
    	$this->addElement($element);
    	
    	
    	$element = new Service_Form_Element_Description('description');
    	$element->setValue($service->description);
    	$this->addElement($element);
    	
    	
    	$element = new Service_Form_Element_Directions('directions');
    	$element->setValue($service->directions);
    	$this->addElement($element);
    	
    	$element = new Service_Form_Element_FlowTest('flow_test');
    	$element->setValue($service->flow_test);
    	$this->addElement($element);
    	
    	$element = new Service_Form_Element_Status('status');
    	$element->setValue($service->status);
    	$this->addElement($element);
    	
    	$element = new Service_Form_Element_Pump('pump');
    	$element->addMultiOption('0', 'Unknown');
    	foreach($pumps as $pump) {
    		$element->addMultiOption($pump->id, $pump->pump_model);
    	}
    	$element->setValue($service->pump);
    	
    	$this->addElement($element);
    	
    	$this->addElement('hash', 'no_csrf', array('salt' => 'unique', 'timeout' => 3600));
    	 
    	$this->addElement(new Application_Form_Element_Submit('submit'));
    	 
    	return $this;
    }
}

