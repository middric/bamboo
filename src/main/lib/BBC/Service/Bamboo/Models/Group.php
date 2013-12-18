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
    protected $_initial_children = array();
    protected $_count = 0;
    protected $_labels = "";
    protected $_related_links = "";
    protected $_stacked = "";
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
     * Returns the subtitle of the episode
     *
     * @return string
     */
    public function getSubtitle() {
        return $this->_subtitle;
    }

    /**
     * Is the group stacked? (All episodes share programme)
     *
     * @return boolean
     */
    public function isStacked() {
        return !!$this->_stacked;
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
        return $this->_initial_children;
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
        return $this->_count;
        // @codingStandardsIgnoreEnd
    }

    /**
     * Get the iStats type of the group
     */
    public function getType() {
        if ($this->getId() === 'popular') {
            $type = 'most-popular';
        } elseif ($this->isStacked()) {
            $type = 'series-catchup';
        } else {
            $type = 'editorial';
        }
        return $type;
    }

}
