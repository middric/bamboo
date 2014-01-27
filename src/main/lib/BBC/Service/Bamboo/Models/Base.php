<?php
/**
 * BBC_Service_Bamboo_Models_Base
 *
 *
 * @category BBC
 * @package BBC_Service_Bamboo_Models
 * @author Matthew Williams <matthew.williams@bbc.co.uk>
 * @copyright Copyright (c) 2013 BBC (http://www.bbc.co.uk)
 */
class BBC_Service_Bamboo_Models_Base
{
    protected $_id = "";
    protected $_title = "";
    protected $_response;
    // @codingStandardsIgnoreStart
    protected $_related_links = array();
    // @codingStandardsIgnoreEnd

    public function __construct($response = array()) {
        $this->_response = $response;
        foreach ($response as $key => $value) {
            switch ($key) {
                case "versions":
                    $this->_setVersions();
                    break;
                case "initial_children":
                    $this->_setEpisodes();
                    break;
                case "episode":
                    $this->_setBroadcastEpisode();
                    break;
                case "episode_large":
                    $this->_setBroadcastEpisode();
                    break;
                case "related_links":
                    $this->_setRelatedLinks();
                    break;
                default:
                    $this->_setProperty($key);
            }
        }
    }

    /**
     * Get the element ID
     * @return string
     */
    public function getId() {
        return $this->_id;
    }

    /**
     * Get the element title
     * @return string
     */
    public function getTitle() {
        return $this->_title;
    }

    /**
     * Get the raw iBL response object
     * @return stdClass
     */
    public function getResponse() {
        return $this->_response;
    }

    public function isFutureDate($date) {
        //If there's only years, make it New Year
        if (is_numeric($date)) {
            $date = "1 Jan ".$date;
        }

        //If date has time we have to take the current time when comparing.
        if ($this->_hasTimeInDate($date)) {
            $now = mktime();
        } else {
            //If not, compare with right before midnight
            $now = mktime(23, 59, 59, date('m'), date('d'), date('y'));
        }

        $releaseTime = strtotime($date);
        if ($releaseTime === false) {
            return false;
        }
        return $now < $releaseTime;
    }

    /**
     * Returns true if a date follows a specific format including the time in a 12-hour format
     * Will return true for 8pm 23 Feb 2010
     * And false for 23 Feb 2010
     * 
     * @param string $date 
     * @return bool
     */
    private function _hasTimeInDate($date) {
        preg_match("/^[0-9]{1,2}(pm|am) [0-9]{1,2} [A-Z]{1}[a-z]{2} [0-9]{4}$/", $date, $matches);
        return count($matches)>0;
    }


    /**
     * Generic method to set a class property to the value stored in iBL
     *
     */
    private function _setProperty($key) {
        if (isset($this->_response->{$key}) && isset($this->{"_$key"})) {
            if (is_array($this->{"_$key"})) {
                $this->{"_$key"} = (array) $this->_response->{$key};
            } else {
                $this->{"_$key"} = $this->_response->{$key};
            }
        } else {
            BBC_Service_Bamboo_Log::info("Expected property \$_$key to be set on " . get_class($this));
        }
    }

    /**
     * For iBL responses with version children this method will generate an array of
     * {@link BBC_Service_Bamboo_Models_Version} objects and attach them to the parent object
     *
     */
    private function _setVersions() {
        if (isset($this->_response->versions) && isset($this->_versions)) {
            foreach ($this->_response->versions as $version) {
                $this->_versions[] = new BBC_Service_Bamboo_Models_Version($version);
            }
        } else {
            BBC_Service_Bamboo_Log::info('Expected property $_versions to be set on ' . get_class($this));
        }
    }

    /**
     * For iBL responses with related link children this method will generate an array of
     * {@link BBC_Service_Bamboo_Models_Related} objects and attach them to the parent object
     *
     */
    private function _setRelatedLinks() {
        // @codingStandardsIgnoreStart
        if (isset($this->_response->related_links) && isset($this->_related_links)) {
            foreach ($this->_response->related_links as $related) {
                $this->_related_links[] = new BBC_Service_Bamboo_Models_Related($related);
            }
        } else {
            BBC_Service_Bamboo_Log::info('Expected property $_related_links to be set on ' . get_class($this));
        }
        // @codingStandardsIgnoreEnd
    }


    /**
     * For iBL responses with episode children this method will generate an array of
     * {@link BBC_Service_Bamboo_Models_Episode} objects and attach them to the parent object
     *
     */
    private function _setEpisodes() {
        // @codingStandardsIgnoreStart
        if (isset($this->_response->initial_children) && isset($this->_initial_children)) {
            foreach ($this->_response->initial_children as $episode) {
                if ($episode->type === 'episode') {
                   $this->_initial_children[] = new BBC_Service_Bamboo_Models_Episode($episode);
                }
                if($episode->type === 'broadcast') {
                    $this->_initial_children[] = new BBC_Service_Bamboo_Models_Broadcast($episode);
                }
            }
        } else {
            BBC_Service_Bamboo_Log::info('Expected property $_initial_children to be set on ' . get_class($this));
        }
        // @codingStandardsIgnoreEnd
    }

    /**
     * For iBL responses with broadcast containing episode child this method will generate an
     * {@link BBC_Service_Bamboo_Models_Episode} object and attach it to the parent object
     *
     */
    private function _setBroadcastEpisode() {
        if (isset($this->_response->episode) && isset($this->_episode)) {
                if (
                    $this->_response->episode->type === 'episode' ||
                    $this->_response->episode->type === 'episode_large'
                ) {
                   $this->_episode = new BBC_Service_Bamboo_Models_Episode($this->_response->episode);
                }
        } else {
            BBC_Service_Bamboo_Log::info('Expected property $_episode to be set on ' . get_class($this));
        }
    }

}
