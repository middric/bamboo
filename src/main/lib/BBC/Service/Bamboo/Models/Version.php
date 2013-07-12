<?php
/**
 * BBC_Service_Bamboo_Models_Version
 *
 *
 * @category BBC
 * @package BBC_Service
 * @subpackage BBC_Service_Bamboo_Models
 * @author Craig Taub <craig.taub@bbc.co.uk>
 * @copyright Copyright (c) 2013 BBC (http://www.bbc.co.uk)
 */
class BBC_Service_Bamboo_Models_Version extends BBC_Service_Bamboo_Models_Base
{
    // Standard version properties
    protected $_kind = "";
    protected $_availability = array();
    protected $_type = "";
    protected $_hd = false;
    protected $_download = false;
    protected $_duration = "";
    protected $_rrc = array();
    protected $_guidance = array();
    // @codingStandardsIgnoreStart
    protected $_credits_timestamp = "";
    // @codingStandardsIgnoreEnd

    public function getAvailability()
    {
        if (isset($this->_availability['end'])) {
            return $this->_availability['end'];
        }
        return "";
    }

    public function getDuration() {
        if ($this->_duration) {
            return new DateInterval($this->_duration);
        }

        return "";
    }

    public function getKind()
    {
        return $this->_kind;
    }

    public function getRRC() {
        return $this->_rrc;
    }

    public function getRRCShort() {
        if (isset($this->_rrc['description']) && isset($this->_rrc['description']->small)) {
            return $this->_rrc['description']->small;
        }

        return '';
    }

    public function getRRCLong() {
        if (isset($this->_rrc['description']) && isset($this->_rrc['description']['large'])) {
            return $this->_rrc['description']['large'];
        }

        return '';
    }

    public function getRRCURL() {
        if (isset($this->_rrc['url'])) {
            return $this->_rrc['url'];
        }

        return '';
    }

    public function getGuidance() {
        if (isset($this->_guidance['text'])) {
            return $this->_guidance['text'];
        }

        return '';
    }

    public function getGuidanceID() {
        if (isset($this->_guidance['id'])) {
            return $this->_guidance['id'];
        }

        return '';
    }

    public function isDownload() {
        return !!$this->_download;
    }

    public function isHD()
    {
        return !!$this->_hd;
    }
}
