<?php
/**
 * Quinns Well And Pump
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.i-support-services.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@i-support-services.com so we can send you a copy immediately.
 *
 * @category   PumpTest
 * @package    Form
 * @copyright  Copyright (c) Jaimie Garner 2013 I Support Services Inc. (http://www.i-support-services.com)
 * @license    http://www.i-support-services.com/license/new-bsd     New BSD License
 * @version    $Id$
 */
class PumpTest_Form_Add extends Zend_Form
{

	/**
	 * Construct
	 */
	public function __construct()
	{
		// this is where i normally set up my decorators for the form and elements
		// additionally you can register prefix paths for custom validators, decorators, and elements
	
		parent::__construct();
		// parent::__construct must be called last because it calls $form->init()
		// and anything after it is not executed
	}
	
	/**
	 * Highlights errored fields
	 */
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
	 * (non-PHPdoc)
	 * @see Zend_Form::init()
	 */
    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
    }

    /**
     * Creates the Add Form for Pump Test
     * 
     * @return PumpTest_Form_Add
     */
    public function pumpTest($locationId)
    {
    	$this->addElement(new PumpTest_Form_Element_Requirements('requirements'));
    	
    	$this->addElement(new PumpTest_Form_Element_Source('source'));
    	
    	$this->addElement(new PumpTest_Form_Element_Depth('depth'));
    	
    	$this->addElement(new PumpTest_Form_Element_Diameter('diameter'));
    	
    	$this->addElement(new PumpTest_Form_Element_Equipment('equipment'));
    	
    	$this->addElement(new PumpTest_Form_Element_Level('level'));
    	
    	$this->addElement(new PumpTest_Form_Element_Vent('vent'));
    	
    	$this->addElement(new PumpTest_Form_Element_Seal('seal'));
    	
    	$this->addElement(new PumpTest_Form_Element_PopOffValve('pop_off_valve'));
    	
    	$this->addElement(new PumpTest_Form_Element_Color('color'));
    	
    	$this->addElement(new PumpTest_Form_Element_Taste('taste'));
    	
    	$this->addElement(new PumpTest_Form_Element_Odor('odor'));
    	
    	$this->addElement(new PumpTest_Form_Element_Employee('employee'));
    	
    	$ownerModel = new Owner_Model_OwnerLocation();
    	$owners = $ownerModel->loadAllOwnerByLocation($locationId);
    	$element = new PumpTest_Form_Element_Owner('owner'); 
    	foreach($owners as $owner) {
    	    $element->addMultiOption($owner->owner_id, $owner->owner_type .' - ' . $owner->name);
    	}
    	$this->addElement($element);
    	
    	
    	
    	$element = new PumpTest_Form_Element_Date('date');
    	$element->setValue(date("M d, Y", time()));
    	$this->addElement($element);
    	
    	$this->addElement(new PumpTest_Form_Element_StartTime('start_time'));
    	
    	//$this->addElement(new PumpTest_Form_Element_StartTime('end_time'));
    	
    	$this->addElement(new PumpTest_Form_Element_Remarks('remarks'));
    	
    	$this->addElement('hash', 'no_csrf', array('salt' => 'unique'));
    	
    	$this->addElement(new Application_Form_Element_Submit('submit'));
    	
    	return $this;
    }
    
    public function flow()
    {
        
        $this->addElement(new PumpTest_Form_Element_StartTime('start_time'));
        
        $this->addElement('hash', 'no_csrf', array('salt' => 'unique'));
         
        $this->addElement(new Application_Form_Element_Submit('submit'));
         
        return $this;
    }

    /**
     * 
     * @param unknown $start
     * @param unknown $end
     */
    public function data($start,$end)
    {
    	$count = 0;
    	for($i=$start*60; $i<=$end*60; $i+=15) {
    		$this->addElement(new PumpTest_Form_Element_Flow('flow['.$count.']'));
    		$this->addElement(new PumpTest_Form_Element_Static('static['.$count.']'));
    		$count++;
    	}			
    	
    	$this->addElement('hash', 'no_csrf', array('salt' => 'unique'));
    	 
    	$this->addElement(new Application_Form_Element_Submit('submit'));
    	 
    	return $this;
    }
}

