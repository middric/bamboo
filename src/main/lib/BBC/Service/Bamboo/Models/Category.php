<?php
/**
 * BBC_Service_Bamboo_Models_Category
 *
 * @category BBC
 * @package BBC_Service
 * @subpackage BBC_Service_Bamboo_Models
 * @author Matthew Williams <matthew.williams@bbc.co.uk>
 * @copyright Copyright (c) 2013 BBC (http://www.bbc.co.uk)
 */
class BBC_Service_Bamboo_Models_Category extends BBC_Service_Bamboo_Models_Base
{
    protected $_kind = "";
    // @codingStandardsIgnoreStart
    protected $_child_episode_count = 0;
    // @codingStandardsIgnoreEnd

    public function getKind() {
        return $this->_kind;
    }

    public function getChildEpisodeCount() {
        // @codingStandardsIgnoreStart
        return $_child_episode_count;
        // @codingStandardsIgnoreEnd
    }
}
