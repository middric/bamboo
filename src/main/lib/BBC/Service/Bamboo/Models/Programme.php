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
     * Get the number of episodes within this programme object
     *
     * @return int
     */
    public function getEpisodeCount() {
        // @codingStandardsIgnoreStart
        return count($this->getEpisodes());
        // @codingStandardsIgnoreEnd
    }

    /**
     * Get the episodes on this programme
     */
    public function getEpisodes() {
        // @codingStandardsIgnoreStart
        return $this->_initial_child_episodes;
        // @codingStandardsIgnoreEnd
    }

    /**
     * Get the total number of episodes available for this programme
     */
    public function getTotalEpisodeCount() {
        // @codingStandardsIgnoreStart
        return $this->_child_episode_count;
        // @codingStandardsIgnoreEnd
    }

    /**
     * Returns true if this programme has an available episode, otherwise false
     */
    public function hasAvailableEpisodes() {
        return count($this->getEpisodes()) > 0;
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
