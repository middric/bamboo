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
    private $_responseDecoded;

    private $_root;

    /**
     * Constructor setting up instance vars for object instance
     * @param stdClass $responseDecoded
     */
    public function __construct($responseDecoded) {
        unset(
            $responseDecoded->version,
            $responseDecoded->schema,
            $responseDecoded->timestamp
        );

        if ($responseDecoded) {
            foreach ($responseDecoded as $key => $value) {
                $this->_root = $key;
                $this->_responseDecoded = $value;
                break;
            }
        }
    }

    /**
     * Build response array based
     * @return Object $responseArray
     */
    public function build() {
        if ($this->_responseDecoded) {
            $responseArray = array();
            switch($this->_root) {
                case 'categories':
                    $responseArray = $this->getCategories($this->_responseDecoded);
                    break;
                case 'group_episodes':
                    $responseArray = $this->getGroupEpisodes($this->_responseDecoded);
                    break;
                case 'channels':
                    $responseArray = $this->getChannels($this->_responseDecoded);
                    break;
                default:
                    $this->_findElements($this->_responseDecoded, $responseArray);
            }

            $response = new BBC_Service_Bamboo_ResponseArrayObject($responseArray);
            
            if (is_array($this->_responseDecoded) || is_object($this->_responseDecoded)) {
                // This needs to be refactored when ibl wraps all of our known objects in an elements array         
                foreach ($this->_responseDecoded as $key => $value) {
                    $ucKey = mb_convert_case($key, MB_CASE_TITLE);
                    $className = "BBC_Service_Bamboo_Models_$ucKey";

                    if (class_exists($className)) {
                        $response->$key = new $className($value);
                    } else {
                        $response->$key = $value;
                    } 
                }
            }

            return $response;
        } else {
            throw new BBC_Service_Bamboo_Exception_EmptyFeed('Feed is empty');
        }
    }

    /**
     * Returns the array of episode objects within a group of episodes
     * @return Object $response
     */
    public function getGroupEpisodes($groupEpisodes) {
        $array = array();
        foreach ($groupEpisodes as $element) {
            //One of the 1st level items will be the array with the episodes 
            if (is_array($element)) {
                foreach ($element as $item) {
                    if ($item->type === "episode") {
                        $array[] = new BBC_Service_Bamboo_Models_Episode($item);
                    } elseif ($item->type === "promotion") {
                        $array[] = new BBC_Service_Bamboo_Models_Promotion($item);
                    }
                }
            }
        }
        return $array;
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

    /**
     * Returns the array of channel objects
     * @return Object $response
     */
    public function getChannels($channels) {
        $array = array();
        foreach ($channels as $element) {
            $item = new BBC_Service_Bamboo_Models_Channel($element);
            $array[] = $item;
        }

        return $array;
    }

    public function getRoot() {
        return $this->_root;
    }

    public function getResponse() {
        return $this->_responseDecoded;
    }

    protected function _findElements($item, &$elements) {
        if (isset($item->type)) {
            $type = str_replace('_large', '', $item->type);
            $className = 'BBC_Service_Bamboo_Models_' . mb_convert_case($type, MB_CASE_TITLE);
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
