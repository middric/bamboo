<?php
/**
 * BBC_Service_Bamboo_Models_Category
 *
 * @category BBC
 * @package BBC_Service_Bamboo_Models
 * @author Matthew Williams <matthew.williams@bbc.co.uk>
 * @copyright Copyright (c) 2013 BBC (http://www.bbc.co.uk)
 */
class BBC_Service_Bamboo_Models_Category extends BBC_Service_Bamboo_Models_Base
{
    protected $_kind = "";
    // @codingStandardsIgnoreStart
    protected $_child_episode_count = 0;
    // @codingStandardsIgnoreEnd

    /**
     * Get the category kind
     *
     * @return string
     */
    public function getKind() {
        return $this->_kind;
    }

    /**
     * Get the number of episodes for a category
     *
     * @return int
     */
    public function getChildEpisodeCount() {
        // @codingStandardsIgnoreStart
        return $_child_episode_count;
        // @codingStandardsIgnoreEnd
    }

    /**
     * Returns whether this category is a children's category
     * @return bool
     */
    public function isChildrens() {
        return $this->_id == 'cbbc' || $this->_id == 'cbeebies';
    }
}
