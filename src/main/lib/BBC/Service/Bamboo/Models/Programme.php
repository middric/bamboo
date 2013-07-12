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
    protected $_initial_child_episodes = array();
    protected $_child_episode_count = 0;

    public function getEpisodeCount()
    {
        return $this->_child_episode_count;
    }

    public function getLatestAvailableEpisode()
    {
        return $this->_initial_child_episodes[0];
    }
}
