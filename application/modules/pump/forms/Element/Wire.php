<?php
class Pump_Form_Element_Wire extends Zend_Form_Element_Select
{
	public function init()
	{
		$this->setLabel('Wire:')
			->setRequired(false)
			->setAttrib('class', 'mini');
		
		$this->addMultiOption('Unknown', 'Unknown')
			->addMultiOption('#(4/0)', '#(4/0)')
			->addMultiOption('#(3/0', '#(3/0')
			->addMultiOption('#(2/0)', '#(2/0)')
			->addMultiOption('#(1/0)', '#(1/0)')
			->addMultiOption('#1', '#1')
			->addMultiOption('#2', '#2')
			->addMultiOption('#3', '#3')
			->addMultiOption('#4', '#4')
			->addMultiOption('#5', '#5')
			->addMultiOption('#6', '#6')
			->addMultiOption('#7', '#7')
			->addMultiOption('#8', '#8')
			->addMultiOption('#9', '#9')
			->addMultiOption('#10', '#10')
			->addMultiOption('#11', '#11')
			->addMultiOption('#12', '#12')
			->addMultiOption('#13', '#13')
			->addMultiOption('#14', '#14')
			->addMultiOption('#15', '#15')
			->addMultiOption('#16', '#16')
			->addMultiOption('#17', '#17')
			->addMultiOption('#18', '#18')
			->addMultiOption('#19', '#19')
			->addMultiOption('#20', '#20')
			->addMultiOption('#21', '#21')
			->addMultiOption('#22', '#22')
			->addMultiOption('#23', '#23')
			->addMultiOption('#24', '#24')
		;
	}
}
