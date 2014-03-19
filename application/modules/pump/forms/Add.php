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
 * @category   Pump
 * @package    Form
 * @copyright  Copyright (c) Jaimie Garner 2013 I Support Services Inc. (http://www.i-support-services.com)
 * @license    http://www.i-support-services.com/license/new-bsd     New BSD License
 * @version    $Id$
 */
class Pump_Form_Add extends Zend_Form
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
    
    public function pump($wellDepth,$pumpTag,$staticLevel,$use,$yield)
    {
    	
    	$this->addElement(new Pump_Form_Element_PumpModel('pump_model'));
    	 
    	
    	$this->addElement(new Pump_Form_Element_PumpType('pump_type'));
    	 
    	$element = new Pump_Form_Element_WellDepth('well_depth');
    	$element->setValue((int)$wellDepth);
    	$this->addElement($element);
    	
    	$this->addElement(new Pump_Form_Element_PumpDepth('pump_depth'));
    	 
    	$this->addElement(new Pump_Form_Element_Voltage('voltage'));
    	
    	$this->addElement( new Pump_Form_Element_Phase('phase'));
    	
    	$this->addElement(new Pump_Form_Element_Wire('wire'));

    	$this->addElement( new Pump_Form_Element_Pipe('pipe'));
   
    	$this->addElement(new Pump_Form_Element_PipeSize('pipe_size'));
    
    	$this->addElement(new Pump_Form_Element_TankSize('tank_size'));
    	 
    	$this->addElement(new Pump_Form_Element_TankModel('tank_model'));
    	
    	$this->addElement(new Pump_Form_Element_TankType('tank_type'));
    	 
    	$this->addElement(new Pump_Form_Element_Filtration('filtration'));
    	 
 	 	$element = new Pump_Form_Element_PumpTag('pump_tag');
 	 	$element->setValue($pumpTag);
 	 	$this->addElement($element);
    	
 	 	$element = new Pump_Form_Element_StaticLevel('static_level');
 	 	$element->setValue((int)$staticLevel);
 	 	$this->addElement($element);
 	 	
 	 	$element = new Pump_Form_Element_Use('use');
 	 	$element->setValue($use);
 	 	$this->addElement($element);
 	 	
 	 	$element = new Pump_Form_Element_Yield('yield');
 	 	$element->setValue((int)$yield);
 	 	$this->addElement($element);
 	 	
    	$this->addElement('hash', 'no_csrf', array('salt' => 'unique', 'timeout' => 3600));
    	
    	$this->addElement(new Application_Form_Element_Submit('submit'));
    	
    	return $this;
    }


}

