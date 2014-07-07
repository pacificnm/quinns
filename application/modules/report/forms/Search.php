<?php
class Report_Form_Search extends Zend_Form
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
	
	public function sites()
	{
		$this->addElement(new Report_Form_Element_Latitude('latitude'));
		
		$this->addElement(new Report_Form_Element_Longitude('longitude'));
		
		$this->addElement(new Report_Form_Element_Township('township'));
		
		$this->addElement(new Report_Form_Element_TownshipChar('township_char'));
		
		$this->addElement(new Report_Form_Element_Range('range'));
		
		$this->addElement(new Report_Form_Element_RangeChar('range_char'));
		
		$this->addElement(new Report_Form_Element_Sctn('sctn'));
		
		$this->addElement(new Report_Form_Element_SectionDivision('sctn_division'));
		
		$element = new Location_Form_Element_Street('street');
		$element->setRequired(false);
		$this->addElement($element);
		
		$element = new Location_Form_Element_City('city');
		$element->setRequired(false);
		$this->addElement($element);
		
		$element = new Owner_Form_Element_Name('name');
		$element->setRequired(false);
		$this->addElement($element);
		
		$element = new Owner_Form_Element_Phone('phone');
		$element->setRequired(false);
		$this->addElement($element);
		
		$element = new Owner_Form_Element_Email('email');
		$element->setRequired(false);
		$this->addElement($element);
		
		$element = new Owner_Form_Element_Street('owner_street');
		$element->setRequired(false);
		$this->addElement($element);
		
		$element = new Owner_Form_Element_City('owner_city');
		$element->setRequired(false);
		$this->addElement($element);
		
		$element = new Owner_Form_Element_State('owner_state');
		$element->setRequired(false);
		$this->addElement($element);
		
		$element = new Owner_Form_Element_Zip('owner_zip');
		$element->setRequired(false);
		$this->addElement($element);
		
		$element = new Report_Form_Element_Records('records');
		$element->setValue('25');
		$element->setRequired(true);
		$this->addElement($element);
		
		$this->addElement('hash', 'no_csrf', array('salt' => 'unique'));
		 
		$this->addElement(new Application_Form_Element_Submit('submit'));
		
		return $this;
	}
}