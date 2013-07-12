<?php
/**
 * BBC_Service_Bamboo_Models_Programme
 *
 *
 * @category BBC
 * @package BBC_Service
 * @subpackage BBC_Service_Bamboo_Models
 * @author Craig Taub <craig.taub@bbc.co.uk>
 * @copyright Copyright (c) 2013 BBC (http://www.bbc.co.uk)
 */
class BBC_Service_Bamboo_Models_Programme extends BBC_Service_Bamboo_Models_Element
{
    // @codingStandardsIgnoreStart
    protected $_initial_child_episodes = array();
    protected $_child_episode_count = 0;
    // @codingStandardsIgnoreEnd

    public function getEpisodeCount()
    {
        // @codingStandardsIgnoreStart
        return $this->_child_episode_count;
        // @codingStandardsIgnoreEnd
    }

    public function getLatestAvailableEpisode()
    {
        // @codingStandardsIgnoreStart
        return $this->_initial_child_episodes[0];
        // @codingStandardsIgnoreEnd
    }
}
