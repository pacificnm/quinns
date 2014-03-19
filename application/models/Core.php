<?php
/**
 * Application Model Core. 
 * Provides core classes 
 * 
 * @author Jaimie Garner
 * @copyright 2013 Jaimie Garner
 *
 * @package Application
 * @category Model
 * @version 1.0
 *
 *
 */
class Application_Model_Core
{

	/**
	 * Used to truncate a string longer than $max characters.
	 * Defaults to 25
	 * 
	 * @param string $string
	 * @param number $max
	 * @return string
	 */
	public function truncate($string, $max=25)
	{
		if(strlen($string) > $max ) {
			$newString = substr($string, 0, $max) . "...";
			return $newString;
		} else {
			return $string;
		}		
	}
	
	/**
	 * Used to create a directory if one does not exist
	 * 
	 * @param string $path The file path to create
	 * @return unknown
	 */
	public function checkDir($path)
	{
		if(!file_exists($path)){
			mkdir($path);
		}
		
		return $path;
	}

	public function fixCase($input)
	{
	
	}
	
	public function removeNonNumeric($string)
	{
		$fix =  preg_replace("/[^0-9,.]/", "", $string);
		
		return $fix;
	}
}

