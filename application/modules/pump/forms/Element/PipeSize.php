<?php
class Pump_Form_Element_PipeSize extends Zend_Form_Element_Select
{
	public function init()
	{
		$this->setLabel('Pipe Size:')
			->setRequired(false)
			->setAttrib('class', 'mini');
		
		$pipeSizeModel = new PipeSize_Model_PipeSize();
		$pipeSizes = $pipeSizeModel->loadAll();
		
		foreach($pipeSizes as $pipeSize) {
			$this->addMultiOption($pipeSize->value, $pipeSize->value);
		}
	}
}