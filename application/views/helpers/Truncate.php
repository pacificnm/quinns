<?php
class View_Helper_Truncate extends Zend_View_Helper_Action
{
	public function truncate($string, $max=25)
	{
		if(strlen($string) > $max ) {
			$newString = substr($string, 0, $max) . "...";
			return $newString;
		} else {
			return $string;
		}
	}
}
