<?php

class Location_Form_Add extends Zend_Form
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

    public function location($street,$city,$state,$zip,$township,$townshipChar,$range,$rangeChar,$sctn)
    {
    	// street
    	$element = new Location_Form_Element_Street('street');
    	$element->setValue($street);
    	$this->addElement($element);
    	
    	$this->addElement(new Location_Form_Element_Street2('street2'));
    	
    	// city
    	$element = new Location_Form_Element_City('city');
    	$element->setValue($city);
    	$this->addElement($element);
    	
    	// state
    	$element = new Location_Form_Element_State('state');
    	$element->setValue($state);
    	$this->addElement($element);
    	
    	// zip
    	$element = new Location_Form_Element_Zip('zip');
    	$element->setValue($zip);
    	$this->addElement($element);
    	
    	// township
    	$element = new Location_Form_Element_Township('township');
    	$element->setValue($township);
    	$this->addElement($element);
    	
    	$element = new Location_Form_Element_TownshipChar('township_char');
    	$element->setValue($townshipChar);
    	$this->addElement($element);
    	
    	$element = new Location_Form_Element_Range('range');
    	$element->setValue($range);
    	$this->addElement($element);
    	
    	$element = new Location_Form_Element_RangeChar('range_char');
    	$element->setValue($rangeChar);
    	$this->addElement($element);
    	
    	$element = new Location_Form_Element_Sctn('sctn');
    	$element->setValue($sctn);
    	$this->addElement($element);
    	
    	
    	$this->addElement('hash', 'no_csrf', array('salt' => 'unique', 'timeout' => 3600));
    	
    	$this->addElement(new Application_Form_Element_Submit('submit'));
    	
    	return $this;
    }

}

