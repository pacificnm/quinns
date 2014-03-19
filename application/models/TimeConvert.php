<?php
class Application_Model_TimeConvert
{
	/**
	 * Convert time into decimal time.
	 *
	 * @param string $time The time to convert
	 *
	 * @return integer The time as a decimal value.
	 */
	function time_to_decimal($time) {
		$timeArr = explode(':', $time);
		$decTime = ($timeArr[0]) + ($timeArr[1]/60) + ($timeArr[2]/3600);
		
		return $decTime;
	}
	
	/**
	 * Convert decimal time into time in the format hh:mm:ss
	 *
	 * @param integer The time as a decimal value.
	 *
	 * @return string $time The converted time value.
	 */
	function decimal_to_time($decimal) {
	    $hours = floor((int)$decimal / 60);
	    $minutes = floor((int)$decimal % 60);
	    $seconds = $decimal - (int)$decimal; 
	    $seconds = round($seconds * 60); 
	 
	    return str_pad($hours, 2, "0", STR_PAD_LEFT) . ":" . str_pad($minutes, 2, "0", STR_PAD_LEFT) . ":" . str_pad($seconds, 2, "0", STR_PAD_LEFT);
	}
}