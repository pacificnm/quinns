<?php

class PumpTest_Form_Edit extends Zend_Form
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
        $this->addElement('hash', 'no_csrf', array('salt' => 'unique'));
    	 
    	$this->addElement(new Application_Form_Element_Submit('submit'));
    }

    public function pumpTest($pumpTest)
    {
    	$element = new PumpTest_Form_Element_Requirements('requirements');
    	$element->setValue($pumpTest->requirements);
    	$this->addElement($element);
    	 
    	$element = new PumpTest_Form_Element_Source('source');
    	$element->setValue($pumpTest->source);
    	$this->addElement($element);
    	 
    	$element = new PumpTest_Form_Element_Depth('depth');
    	$element->setValue($pumpTest->depth);
    	$this->addElement($element);
    	 
    	$element = new PumpTest_Form_Element_Diameter('diameter');
    	$element->setValue($pumpTest->diameter);
    	$this->addElement($element);
    	 
    	$element = new PumpTest_Form_Element_Equipment('equipment');
    	$element->setValue($pumpTest->equipment);
    	$this->addElement($element);
    	 
    	$element = new PumpTest_Form_Element_Level('level');
    	$element->setValue($pumpTest->level);
    	$this->addElement($element);
    	 
    	$element = new PumpTest_Form_Element_Vent('vent');
    	$element->setValue($pumpTest->vent);
    	$this->addElement($element);
    	 
    	$element = new PumpTest_Form_Element_Seal('seal');
    	$element->setValue($pumpTest->seal);
    	$this->addElement($element);
    	 
    	$element = new PumpTest_Form_Element_PopOffValve('pop_off_valve');
    	$element->setValue($pumpTest->pop_off_valve);
    	$this->addElement($element);
    	 
    	$element = new PumpTest_Form_Element_Color('color');
    	$element->setValue($pumpTest->color);
    	$this->addElement($element);
    	 
    	$element = new PumpTest_Form_Element_Taste('taste');
    	$element->setValue($pumpTest->taste);
    	$this->addElement($element);
    	 
    	$element = new PumpTest_Form_Element_Odor('odor');
    	$element->setValue($pumpTest->odor);
    	$this->addElement($element);
    	 
    	$element = new PumpTest_Form_Element_Employee('employee');
    	$element->setValue($pumpTest->employee);
    	$this->addElement($element);
    	 
    	$ownerModel = new Owner_Model_Owner();
    	
    	$ownerModel = new Owner_Model_OwnerLocation();
    	$owners = $ownerModel->loadAllOwnerByLocation($pumpTest->location);
    	$element = new PumpTest_Form_Element_Owner('owner');
    	foreach($owners as $owner) {
    	    $element->addMultiOption($owner->owner_id, $owner->owner_type .' - ' . $owner->name);
    	}
    	$element->setValue($pumpTest->owner);
    	$this->addElement($element);
    	
    	
    	
    	
    	 
    	$element = new PumpTest_Form_Element_Date('date');
    	$element->setValue(date("M d, Y", $pumpTest->date));
    	$this->addElement($element);
    	 

    	$element = new PumpTest_Form_Element_Remarks('remarks');
    	$element->setValue($pumpTest->remarks);
    	$this->addElement($element);
    	 
    	
    	 
    	return $this;
    }

    public function flow($pumpFlow)
    {
    	
    	foreach($pumpFlow as $flow)
    	{
    		$element = new PumpTest_Form_Element_Flow('flow['.$flow->id.']');
    		$element->setValue($flow->flow);
    		$this->addElement($element);
    		
    		$element = new PumpTest_Form_Element_Static('static['.$flow->id.']');
    		$element->setValue($flow->static);
    		$this->addElement($element);
    	}
    	
    	return $this;
    }
}

