<?php
/**
 * BBC_Service_Bamboo_Models_Group
 *
 *
 * @category BBC
 * @package BBC_Service
 * @subpackage BBC_Service_Bamboo_Models
 * @author Craig Taub <craig.taub@bbc.co.uk>
 * @copyright Copyright (c) 2013 BBC (http://www.bbc.co.uk)
 */
class BBC_Service_Bamboo_Models_Group extends BBC_Service_Bamboo_Models_Element
{
    protected $_subtitle = "";
    // @codingStandardsIgnoreStart
    protected $_initial_child_episodes = "";
    protected $_child_episode_count = "";
    // @codingStandardsIgnoreEnd

    public function getInitialChildEpisodes() {
    	// @codingStandardsIgnoreStart
        return $this->_initial_child_episodes;
        // @codingStandardsIgnoreEnd
    }

    public function getChildEpisodeCount() {
    	// @codingStandardsIgnoreStart
        return $this->_child_episode_count;
        // @codingStandardsIgnoreEnd
    }
}