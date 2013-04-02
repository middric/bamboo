<?php
/**
 * BBC_Service_Bamboo
 * 
 * A service class
 * 
 * @category BBC
 * @package BBC_Service
 * @copyright Copyright (c) 2007 - 2009 BBC (http://www.bbc.co.uk)
 * @author 
 */

class BBC_Service_Bamboo implements BBC_Service_Interface {
	
	/**
	 * Construct a new BBC_Service_Bamboo
	 * 
	 * @param $text
	 * @return void
	 */
	public function __construct() {
	}
	
	/**
	 * Returns the name of the service
	 * 
	 * @return string
	 */
	public static function getName() {
		return 'bamboo';
	}
	
	/**
	 * Returns the class version
	 * 
	 * @return string
	 */
	public static function getVersion() {
		return '0.0.1';
	}
	
	/**
	 * Returns an instance of the class
	 * 
	 * @param array $params  Parameters received from BBC_Service_Broker
	 * @return BBC_Service_Bamboo
	 */
	public static function getInstance(array $params = array()) {
		return new BBC_Service_Bamboo();
	}
}
