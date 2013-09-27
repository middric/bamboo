<?php
/**
 * BBC_Service_Bamboo_Models_Promotion
 * 
 * @category BBC
 * @package BBC_Service_Bamboo_Models
 * @author Miguel L Gonzalez <miguel.gonzalez@bbc.co.uk>
 * @copyright Copyright (c) 2013 BBC (http://www.bbc.co.uk)
 */
class BBC_Service_Bamboo_Models_Promotion extends BBC_Service_Bamboo_Models_Element
{
    protected $_url = "";
    protected $_subtitle = "";
    protected $_labels = array();

    /**
     * Returns the subtitle of the promotion, which is stored in the synopses
     * 
     * @access public
     * @return string
     */
    public function getSubtitle() {
        return $this->_subtitle;
    }

    /**
     * Returns the description of the promotion, which is stored in the synopses
     * 
     * @access public
     * @return string
     */
    public function getDescription() {
        if (isset($this->_synopses['small'])) {
            return $this->_synopses['small'];
        }
        return "";
    }

    /**
     * Returns the editorial label of the promotion, which is stored in the title
     * 
     * @access public
     * @return string
     */
    public function getPromotionLabel() {
        if (isset($this->_labels['promotion'])) {
            return $this->_labels['promotion'];
        }
        return "";
    }

    /**
     * Get the Promotion URL
     * Even though the underlying field is URL, other models use getHref.
     *
     * @return string
     */
    public function getUrl() {
        return $this->_url;
    }

}
