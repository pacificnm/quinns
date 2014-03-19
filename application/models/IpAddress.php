<?php
/**
 * 
 * @author Jaimie
 *
 */
class Application_Model_IpAddress
{
	/**
	 * 
	 * @return string user ip address
	 */
	public function getUserIp()
	{
		//check ip from share internet
		if (!empty($_SERVER['HTTP_CLIENT_IP'])){
			$ip = $_SERVER['HTTP_CLIENT_IP'];
			
			//to check ip is pass from proxy
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
	
}