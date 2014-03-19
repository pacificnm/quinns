<?php
class View_Helper_Auth 
{
	public function auth()
	{
		$auth = Zend_Auth::getInstance();
		
		return $auth;
	}
}