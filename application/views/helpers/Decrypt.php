<?php
class View_Helper_Decrypt extends Zend_View_Helper_Action
{
	public function Decrypt($string)
	{
		$crypt = new Application_Model_Crypt();
		
		$dstring = $crypt->decrypt($string);
		
		return $dstring;
	}
}