<?php
/**
 * BBC_Service_Bamboo_Models_Related
 * 
 * @category BBC
 * @package BBC_Service_Bamboo_Models
 * @author Charlie Rogers <charles.rogers@bbc.co.uk>
 * @copyright Copyright (c) 2013 BBC (http://www.bbc.co.uk)
 */
class BBC_Service_Bamboo_Models_Related extends BBC_Service_Bamboo_Models_Element
{
    protected $_url = "";
    protected $_kind = "";

    /**
     * Returns the kind of the related link (e.g. priority_content).
     * This is different to the type (e.g. url)
     * 
     * @access public
     * @return string
     */
    public function getKind() {
        return $this->_kind;
    }

    /**
     * Returns the description of the related link, which is stored in the synopses
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
     * Get the Related Link URL
     * Even though the underlying field is URL, other models use getHref.
     *
     * @return string
     */
    public function getUrl() {
        return $this->_url;
    }

}
