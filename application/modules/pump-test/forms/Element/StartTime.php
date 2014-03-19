<?php
class PumpTest_Form_Element_StartTime extends Zend_Form_Element_Select
{
	public function init()
	{
		$this->setLabel('Test Start Time:');
		
		
		for($i=8.5*60;$i<=17.5*60;$i+=15) {
			$startHour = floor($i/60); 
			$startMin = ($i/60-floor($i/60))*60;
			$startTime = mktime($startHour,$startMin,0,date("m"),date("d"),date("Y"));
			
			
  			$this->addMultiOption($startTime ,date("h:i A",$startTime));
		}
		
	}
}