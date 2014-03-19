<?php
/**
 * Application Model GoogleMaps class for Google Maps 
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
class Application_Model_GoogleMaps
{

	/**
	 * 
	 * @var string
	 */
	protected $_uri = 'http://maps.googleapis.com/maps/api/directions/json?';
	
	/**
	 * 
	 * @var unknown
	 */
	protected $_body;
	
	
	/**
	 * 
	 * @param string $origin
	 * @param string $destination
	 * @return mixed
	 */
	public function getDirections($origin,$destination)
	{
		$client = new Zend_Http_Client();
		$client->setUri($this->getUri());
		
		$client->setConfig(array(
				'maxredirects' => 0,
				'timeout'      => 30));
		
		$client->setParameterGet(array(
				'origin'  => $origin,
				'destination' => $destination,
				'sensor'     => 'false',
		));
		
		$response = $client->request();
		$this->_body = Zend_Json::decode($response->getBody(), Zend_Json::TYPE_ARRAY);

		return $this->_body;
	}
	
	/**
	 * returns distance in miles rounded up
	 */
	public function getDistance()
	{
		return  $this->_body['routes'][0]['legs'][0]['distance']['text'];
	}
	
	public function getDuration()
	{
		return $this->_body['routes'][0]['legs'][0]['duration']['text'];
	}
	
	
	
	public function getStatus()
	{
		 return $this->_body['status'];
	}
	
	public function getDrivingDirections()
	{
		return $this->_body['routes'][0]['legs'];
	}
	
	public function getLon()
	{
		return $this->_body['routes'][0]['legs'][0]['end_location']['lng'];
	}
	
	public function getLat()
	{
		return $this->_body['routes'][0]['legs'][0]['end_location']['lat'];
	}
	/**
	 * 
	 * @return string
	 */
	private function getUri()
	{
		return $this->_uri;
	}
}

