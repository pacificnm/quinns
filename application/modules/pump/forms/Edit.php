<?php

class Pump_Form_Edit extends Zend_Form
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
    
    	 
    }

    public function pump($pump,$tank)
    {
    	
    	$element = new Pump_Form_Element_PumpModel('pump_model');
    	$element->setValue($pump->pump_model);
    	$this->addElement($element);
    	
    	$element = new Pump_Form_Element_PumpType('pump_type');
    	$element->setValue($pump->pump_type);
    	$this->addElement($element);
    	
    	$element = new Pump_Form_Element_WellDepth('well_depth');
    	$element->setValue($pump->well_depth);
    	$this->addElement($element);
    	
    	$element = new Pump_Form_Element_PumpDepth('pump_depth');
    	$element->setValue($pump->pump_depth);
    	$this->addElement($element);
    	
    	$element = new Pump_Form_Element_Voltage('voltage');
    	$element->setValue($pump->voltage);
    	$this->addElement($element);
    	
    	$element = new Pump_Form_Element_Phase('phase');
    	$element->setValue($pump->phase);
    	$this->addElement($element);
    	
    	$element = new Pump_Form_Element_Wire('wire');
    	$element->setValue($pump->wire);
    	$this->addElement($element);
    	
    	$element = new Pump_Form_Element_Pipe('pipe');
    	$element->setValue($pump->pipe);
    	$this->addElement($element); 	
    	
    	$element = new Pump_Form_Element_PipeSize('pipe_size');
    	$element->setValue($pump->pipe_size);
    	$this->addElement($element);
    	

    	$element = new Pump_Form_Element_TankSize('tank_size');
    	$element->setValue($tank->size);
    	$this->addElement($element);
    	
    	$element = new Pump_Form_Element_TankModel('tank_model');
    	$element->setValue($tank->model);
    	$this->addElement($element);
    	
    	$element = new Pump_Form_Element_TankType('tank_type');
    	$element->setValue($tank->type);
    	$this->addElement($element);
    	
    	$element = new Pump_Form_Element_Filtration('filtration');
    	$element->setValue($tank->filtration);
    	$this->addElement($element);
    	
    	$element = new Pump_Form_Element_PumpTag('pump_tag');
    	$element->setValue($pump->pump_tag);
    	$this->addElement($element);
    	 
    	$element = new Pump_Form_Element_StaticLevel('static_level');
    	$element->setValue($pump->static_level);
    	$this->addElement($element);
    	
    	$element = new Pump_Form_Element_Use('use');
    	$element->setValue($pump->use);
    	$this->addElement($element);
    	
    	$element = new Pump_Form_Element_Yield('yield');
    	$element->setValue($pump->yield);
    	$this->addElement($element);
    	
    	$this->addElement('hash', 'no_csrf', array('salt' => 'unique', 'timeout' => 3600));
    	 
    	$this->addElement(new Application_Form_Element_Submit('submit'));
    	 
    	return $this;
    }

}

