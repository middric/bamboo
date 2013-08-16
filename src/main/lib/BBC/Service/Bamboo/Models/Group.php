<?php
/**
 * BBC_Service_Bamboo_Models_Group
 *
 *
 * @category BBC
 * @package BBC_Service_Bamboo_Models
 * @author Craig Taub <craig.taub@bbc.co.uk>
 * @copyright Copyright (c) 2013 BBC (http://www.bbc.co.uk)
 */
class BBC_Service_Bamboo_Models_Group extends BBC_Service_Bamboo_Models_Element
{
    protected $_subtitle = "";
    // @codingStandardsIgnoreStart
    protected $_initial_child_episodes = "";
    protected $_child_episode_count = "";
    protected $_labels = "";
    protected $_related_links = "";
    protected $_master_brand = "";
    // @codingStandardsIgnoreEnd

    /**
     * Returns the related links
     * 
     * @return object
     */
    public function getRelatedLinks() {
    	// @codingStandardsIgnoreStart
        return $this->_related_links;
    	// @codingStandardsIgnoreEnd
    }

    /**
     * Returns the master brand
     * 
     * @return object
     */
    public function getMasterBrand() {
    	// @codingStandardsIgnoreStart
        return $this->_master_brand;
    	// @codingStandardsIgnoreEnd
    }

    /**
     * Returns the subtitle of the episode
     *
     * @return string
     */
    public function getSubtitle() {
        return $this->_subtitle;
    }

    /**
     * @todo Not sure this is relevant any longer
     */
    public function getLabels() {
        return $this->_labels;
    }

    /**
     * @todo Not sure this is relevant any longer
     */
    public function getEpisodes() {
    	// @codingStandardsIgnoreStart
        return $this->_initial_child_episodes;
        // @codingStandardsIgnoreEnd
    }

    /**
     * Get the number of episodes within this group object
     */
    public function getEpisodeCount() {
        return count($this->getEpisodes());
    }

    /**
     * Get the total number of episodes in this group
     */
    public function getTotalEpisodeCount() {
    	// @codingStandardsIgnoreStart
        return $this->_child_episode_count;
        // @codingStandardsIgnoreEnd
    }
}
