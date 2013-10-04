<?php
/**
 * BBC_Service_Bamboo_Models_Broadcast
 *
 *
 * @category BBC
 * @package BBC_Service_Bamboo_Models
 * @author Craig Taub <craig.taub@bbc.co.uk>
 * @copyright Copyright (c) 2013 BBC (http://www.bbc.co.uk)
 */
class BBC_Service_Bamboo_Models_Broadcast extends BBC_Service_Bamboo_Models_Base
{
    protected $_type = "";
    // @codingStandardsIgnoreStart
    protected $_start_time = "";
    protected $_end_time = "";
    // @codingStandardsIgnoreEnd
    protected $_duration = array();
    protected $_episode = "";

    /**
     * Get type 
     * 
     * @return string
     */
    public function getType() {
        return $this->_type;
    }

    /**
     * Get start time from episode
     * 
     * @return string
     */
    public function getStartTime() {
        // @codingStandardsIgnoreStart
        return $this->_start_time;
        // @codingStandardsIgnoreEnd
    }

    /**
     * Get end time from episode
     * 
     * @return string
     */
    public function getEndTime() {
        // @codingStandardsIgnoreStart
        return $this->_end_time;
        // @codingStandardsIgnoreEnd
    }

    /**
     * Get episode inside Broadcast
     * 
     * @return BBC_Service_Bamboo_Models_Episode
     */
    public function getEpisode() {
        return $this->_episode;
    }

}