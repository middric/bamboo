<?php
/**
 * BBC_Service_Bamboo_Models_Base
 *
 *
 * @category BBC
 * @package BBC_Service
 * @subpackage BBC_Service_Bamboo_Models
 * @author Matthew Williams <matthew.williams@bbc.co.uk>
 * @copyright Copyright (c) 2013 BBC (http://www.bbc.co.uk)
 */
class BBC_Service_Bamboo_Models_Base
{
    protected $_id = "";
    protected $_title = "";
    protected $_response;

    public function __construct($response) {
        $this->_response = $response;
        foreach ($response as $key => $value) {
            switch ($key) {
                case "versions":
                    $this->_setVersions();
                    break;
                case "initial_child_episodes":
                    $this->_setEpisodes();
                    break;
                default:
                    $this->_setProperty($key);
            }
        }
    }

    public function getId() {
        return $this->_id;
    }

    public function getTitle() {
        return $this->_title;
    }

    public function getResponse()
    {
        return $this->_response;
    }

    private function _setProperty($key) {
        if (isset($this->_response->{$key}) && isset($this->{"_$key"})) {
            if (is_array($this->{"_$key"})) {
                $this->{"_$key"} = (array) $this->_response->{$key};
            } else {
                $this->{"_$key"} = $this->_response->{$key};
            }
        } else {
            throw new BBC_Service_Bamboo_Exception_ExpectedProperty(
                "Expected property \$_$key to be set on " . get_class($this)
            );
        }
    }

    private function _setVersions() {
        if (isset($this->_response->versions) && isset($this->_versions)) {
            foreach ($this->_response->versions as $version) {
                $this->_versions[] = new BBC_Service_Bamboo_Models_Version($version);
            }
        } else {
            throw new BBC_Service_Bamboo_Exception_ExpectedProperty(
                "Expected property \$_versions to be set on " . get_class($this)
            );
        }
    }

    private function _setEpisodes() {
        // @codingStandardsIgnoreStart
        if (isset($this->_response->initial_child_episodes) && isset($this->_initial_child_episodes)) {
            foreach ($this->_response->initial_child_episodes as $episode) {
                $this->_initial_child_episodes[] = new BBC_Service_Bamboo_Models_Episode($episode);
            }
        } else {
            throw new BBC_Service_Bamboo_Exception_ExpectedProperty(
                "Expected property \$_initial_child_episodes to be set on " . get_class($this)
            );
        }
        // @codingStandardsIgnoreEnd
    }
}
