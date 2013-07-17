<?php
/**
 * BBC_Service_Bamboo_Models_Programme
 *
 *
 * @category BBC
 * @package BBC_Service_Bamboo_Models
 * @author Craig Taub <craig.taub@bbc.co.uk>
 * @copyright Copyright (c) 2013 BBC (http://www.bbc.co.uk)
 */
class BBC_Service_Bamboo_Models_Programme extends BBC_Service_Bamboo_Models_Element
{
    // @codingStandardsIgnoreStart
    protected $_initial_child_episodes = array();
    protected $_child_episode_count = 0;
    // @codingStandardsIgnoreEnd

    /**
     * Get the number of episodes for this programme
     * 
     * @return int
     */
    public function getEpisodeCount() {
        // @codingStandardsIgnoreStart
        return $this->_child_episode_count;
        // @codingStandardsIgnoreEnd
    }

    /**
     * Get the latest episode
     * 
     * @return BBC_Service_Bamboo_Models_Episode
     */
    public function getLatestAvailableEpisode() {
        // @codingStandardsIgnoreStart
        if (isset($this->_initial_child_episodes[0])) {
            return $this->_initial_child_episodes[0];
        } 
        return "";
        // @codingStandardsIgnoreEnd
    }
}
