<?php
class Service_Form_Decorator_EndTime extends Zend_Form_Decorator_Abstract
{
	public function render($content)
	{
		$element = $this->getElement();
		if (!$element instanceof Service_Form_Element_EndTime) {
			// only want to render Date elements
			return $content;
		}
	
		$view = $element->getView();
		if (!$view instanceof Zend_View_Interface) {
			// using view helpers, so do nothing if no view present
			return $content;
		}
	
		$hour  = $element->getHour();
		$min   = $element->getMin();
		$amPm  = $element->getAmPm();
		$name  = $element->getFullyQualifiedName();
		
		$params = array(
				'size'      => 2,
				'maxlength' => 2,
		);
		$yearParams = array(
				'size'      => 4,
				'maxlength' => 4,
		);
	
		$markup = '<select name="endHour" id="endHour">';
				$i = 0;
				while($i < 13){
					$markup .= '<option value="'.$i.'">'.$i.'</option>';
					$i++;
				}
		$markup .= '</select> : <select name="endMin" id="endMin">';
		$markup .= '<option value="00">00</option>';
		$markup .= '<option value="15">15</option>';
		$markup .= '<option value="30">30</option>';
		$markup .= '<option value="45">45</option>';
		$markup .= '</select>';
		
		$markup .= ': <select name="endAmpm" id="endAmpm">';
		$markup .= '<option value="AM">AM</option>';
		$markup .= '<option value="PM">PM</option></select>';
		
		
		/**$markup = $view->formText($name . '[hour]', $hour, $params)
		. ' : ' . $view->formText($name . '[min]', $min, $params);*/
	
		switch ($this->getPlacement()) {
			case self::PREPEND:
				return $markup . $this->getSeparator() . $content;
			case self::APPEND:
			default:
				return $content . $this->getSeparator() . $markup;
		}
	}
	
}