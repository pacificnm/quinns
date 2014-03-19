<?php

class Location_Form_Edit extends Zend_Form
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
    
    /**
     * 
     * @param unknown $location
     * @return Location_Form_Edit
     */
    public function location($location)
    {
    	$element = new Location_Form_Element_Street('street');
    	$element->setValue($location->street);
    	$this->addElement($element);
    	
    	$element = new Location_Form_Element_Street2('street2');
    	$element->setValue($location->street2);
    	$this->addElement($element);
    	
    	$element = new Location_Form_Element_City('city');
    	$element->setValue($location->city);
    	$this->addElement($element);
    	
    	$element = new Location_Form_Element_State('state');
    	$element->setValue($location->state);
    	$this->addElement($element);
    	
    	$element = new Location_Form_Element_Zip('zip');
    	$element->setValue($location->zip);
    	$this->addElement($element);
    	
    	$this->addElement('hash', 'no_csrf', array('salt' => 'unique', 'timeout' => 3600));
    	
    	$this->addElement(new Application_Form_Element_Submit('submit'));
    	
    	return $this;
    }
    
    public function note($locationNote)
    {
    	$element = new Location_Form_Element_Note('note');
    	$element->setValue($locationNote->note);
    	$this->addElement($element);
    	
    	$element = new Location_Form_Element_Directions('directions');
    	$element->setValue($locationNote->directions);
    	$this->addElement($element);
    	
    	$element = new Location_Form_Element_Access('access');
    	$element->setValue($locationNote->access);
    	$this->addElement($element);
    	
    	$element = new Location_Form_Element_BoomTruck('boom_truck');
    	$element->setValue($locationNote->boom_truck);
    	$this->addElement($element);
    	
    	$element = new Location_Form_Element_Dog('dog');
    	$element->setValue($locationNote->dog);
    	$this->addElement($element);
    	
    	$element = new Location_Form_Element_Men('men');
    	$element->setValue($locationNote->men);
    	$this->addElement($element);
    	
    	$element = new Location_Form_Element_Explanation('explanation');
    	$element->setValue($locationNote->explanation);
    	$this->addElement($element);
    	
    	$this->addElement('hash', 'no_csrf', array('salt' => 'unique', 'timeout' => 3600));
    	 
    	$this->addElement(new Application_Form_Element_Submit('submit'));
    	 
    	return $this;
    }


    public function service($service)
    {
    	$element = new Location_Form_Element_Date('date');
    	@$element->setValue(date("M d,Y",$service->service_due));
    	
    	$this->addElement($element);
    	
    	$this->addElement('hash', 'no_csrf', array('salt' => 'unique', 'timeout' => 3600));
    	
    	$this->addElement(new Application_Form_Element_Submit('submit'));
    	
    	return $this;
    }
}

