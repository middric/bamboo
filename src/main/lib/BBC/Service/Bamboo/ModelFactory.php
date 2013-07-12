<?php
/**
 * BBC_Service_Bamboo_ModelFacgtory
 *
 *
 * @category BBC
 * @package BBC_Service
 * @subpackage BBC_Service_Bamboo
 * @author Craig Taub <craig.taub@bbc.co.uk>
 * @copyright Copyright (c) 2013 BBC (http://www.bbc.co.uk)
 */
class BBC_Service_Bamboo_ModelFactory
{
    /**
     * @var stdClass object
     */
	private $_response_decoded;

	private $_root;

    /**
     * Constructor setting up instance vars for object instance
     * @param stdClass $response_decoded
     */
	public function __construct($response_decoded) {
		unset(
			$response_decoded->version,
			$response_decoded->schema,
			$response_decoded->timestamp
		);

		foreach ($response_decoded as $key => $value) {
			$this->_root = $key;
			$this->_response_decoded = $value;
			break;
		}
	}

    /**
     * Build response array based 
     * @return Object $response_array
     */
	public function build() {
		if ($this->_response_decoded) {
			$response_array = array();			

			switch($this->_root) {
				case 'categories': 
					$response_array = $this->getCategories($this->_response_decoded);
					break;
				case 'channels': 
					//$response_array = $this->getChannels($this->_response_decoded);
					break;

				default:
					$this->_findElements($this->_response_decoded, $response_array);
			}

			$response = new ArrayObject($response_array);

			// This needs to be refactored when ibl wraps all of our known objects in an elements array
			foreach($this->_response_decoded as $key => $value) {
				$response->$key = $value;
			}

		    return $response;
		} else {
			throw new BBC_Service_Bamboo_Exception_EmptyFeed('Feed is empty');
		}
	}

    /**
     * Returns the array of category objects 
     * @return Object $response
     */
	public function getCategories($categories) {
		$array = array();
		foreach ($categories as $element) {
			$item = new BBC_Service_Bamboo_Models_Category($element);
			$array[] = $item;
		}

		return $array;
	}

	public function getRoot() {
		return $this->_root;
	}

	public function getResponse() {
		return $this->_response_decoded;
	}

	protected function _findElements($item, &$elements) {
		if (isset($item->type)) {
			$type = str_replace('_large', '', $item->type);
			$className = 'BBC_Service_Bamboo_Models_' . ucfirst($type);
			if (class_exists($className)) {
				$elements[] = new $className($item);
			}
		} elseif (is_array($item) || is_object($item)) {
			foreach ($item as $key => $value) {
				$this->_findElements($value, $elements);
			}
		}
	}

}
