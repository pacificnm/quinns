<?php

class Application_Model_Crypt
{

	protected $_key = 'Apollo!1'; // 8-32 characters without spaces
	
	
	public function crypt($str)
	{
		
		if($this->_key=='')return $str;
		$this->_key=str_replace(chr(32),'',$this->_key);
		if(strlen($this->_key)<8)exit('key error');
		$kl=strlen($this->_key)<32?strlen($this->_key):32;
		$k=array();for($i=0;$i<$kl;$i++){
			$k[$i]=ord($this->_key{$i})&0x1F;
		}
		$j=0;for($i=0;$i<strlen($str);$i++){
			$e=ord($str{$i});
			$str{$i}=$e&0xE0?chr($e^$k[$j]):chr($e);
			$j++;$j=$j==$kl?0:$j;
		}
		return $str;
		
	}
	
	public function decrypt($str)
	{
		if($this->_key=='')return $str;
		$this->_key=str_replace(chr(32),'',$this->_key);
		if(strlen($this->_key)<8)exit('key error');
		$kl=strlen($this->_key)<32?strlen($this->_key):32;
		$k=array();for($i=0;$i<$kl;$i++){
			$k[$i]=ord($this->_key{$i})&0x1F;
		}
		$j=0;for($i=0;$i<strlen($str);$i++){
			$e=ord($str{$i});
			$str{$i}=$e&0xE0?chr($e^$k[$j]):chr($e);
			$j++;$j=$j==$kl?0:$j;
		}
		return $str;
	}
	
	
}

