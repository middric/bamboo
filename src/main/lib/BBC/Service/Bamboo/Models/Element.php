<?php
/**
 * BBC_Service_Bamboo_Models_Element
 *
 *
 * @category BBC
 * @package BBC_Service
 * @subpackage BBC_Service_Bamboo_Models
 * @author Matthew Williams <matthew.williams@bbc.co.uk>
 * @copyright Copyright (c) 2013 BBC (http://www.bbc.co.uk)
 */
class BBC_Service_Bamboo_Models_Element extends BBC_Service_Bamboo_Models_Base
{
    protected $_type = '';
    protected $_synopses = array();
    protected $_images = array();
    // @codingStandardsIgnoreStart
    protected $_master_brand = array();
    // @codingStandardsIgnoreEnd

    public function getShortSynopsis()
    {
        if (isset($this->_synopses['small'])) {
            return $this->_synopses['small'];
        }
        return "";
    }

    public function getMediumSynopsis()
    {
        if (isset($this->_synopses['medium'])) {
            return $this->_synopses['medium'];
        }
        return "";
    }

    public function getLargeSynopsis()
    {
        if (isset($this->_synopses['large'])) {
            return $this->_synopses['large'];
        }
        return "";
    }

    public function getStandardImage($width = 336, $height = 189)
    {
        $dimensions = "{$width}x{$height}";
        if (isset($this->_images['standard'])) {
            return str_replace('{recipe}', $dimensions, $this->_images['standard']);
        }
        return "";
    }

    public function getStandardImageRecipe()
    {
        if (isset($this->_images['standard'])) {
            return $this->_images['standard'];
        }
        return "";
    }

    public function getMasterBrand()
    {
        // @codingStandardsIgnoreStart
        if (isset($this->_master_brand['name'])) {
            return $this->_master_brand['name'];
        }
        // @codingStandardsIgnoreEnd
        return "";
    }

    public function getMasterBrandId()
    {
        // @codingStandardsIgnoreStart
        if (isset($this->_master_brand['id'])) {
            return $this->_master_brand['id'];
        }
        // @codingStandardsIgnoreEnd
        return "";
    }

    public function getType() {
        return $this->_type;
    }

}
