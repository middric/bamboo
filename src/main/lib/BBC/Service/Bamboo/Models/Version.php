<?php
/**
 * BBC_Service_Bamboo_Models_Version
 *
 *
 * @category BBC
 * @package BBC_Service_Bamboo_Models
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
    protected $_duration = array();
    protected $_rrc = array();
    protected $_guidance = array();
    // @codingStandardsIgnoreStart
    protected $_credits_timestamp = "";
    // @codingStandardsIgnoreEnd
    protected $_events = array();

    /**
     * Get the availability for this version
     *
     * @param string $type start, end or remaining
     * @return string
     */
    public function getAvailability($type = 'end') {
        if (isset($this->_availability[$type])) {
            return $this->_availability[$type];
        }
        return "";
    }

    /**
     * Get onward journey time
     *
     * @return string
     */
    public function getOnwardJourneyTime() {
        if (!empty($this->_events)) {
            foreach ($this->_events as $event) {
                if ($event->kind == 'onward_journey') {
                    // @codingStandardsIgnoreStart
                    return $event->time_offset_seconds;
                    // @codingStandardsIgnoreEnd
                }
            }
        }
        return "";
    }
    /**
     * Get the version duration
     *
     * @return string
     */
    /**
     * getRemainingAvailability
     *
     * @access public
     * @return void
     */
    public function getRemainingAvailability()
    {
        if (isset($this->_availability['remaining'])) {
            return $this->_availability['remaining']->text;
        }
        return "";
    }


    public function getDuration()
    {
        if (isset($this->_duration['text'])) {
            return $this->_duration['text'];
        }
        return "";
    }

    /**
     * Get the version kind
     *
     * @return string
     */
    public function getKind() {
        return $this->_kind;
    }

    /**
     * Get the version RRC
     *
     * @return stdClass
     */
    public function getRRC() {
        return $this->_rrc;
    }

    /**
     * Get the version RRC short description
     *
     * @return string
     */
    public function getRRCShort() {
        if (isset($this->_rrc['description']) && isset($this->_rrc['description']->small)) {
            return $this->_rrc['description']->small;
        }

        return '';
    }

    /**
     * Get the version RRC long description
     *
     * @return string
     */
    public function getRRCLong() {
        if (isset($this->_rrc['description']) && isset($this->_rrc['description']['large'])) {
            return $this->_rrc['description']['large'];
        }

        return '';
    }

    /**
     * Get the version RRC URL
     *
     * @return string
     */
    public function getRRCURL() {
        if (isset($this->_rrc['url'])) {
            return $this->_rrc['url'];
        }

        return '';
    }

    /**
     * Get the version guidance object
     *
     * @return stdClass
     */
    public function getGuidanceObj() {
        return $this->_guidance;
    }

    /**
     * Get the version guidance text
     *
     * @return string
     */
    public function getGuidance() {
        if (isset($this->_guidance['text'])) {
            return $this->_guidance['text'];
        }

        return '';
    }

    /**
     * Get the version guidance ID
     *
     * @return string
     */
    public function getGuidanceID() {
        if (isset($this->_guidance['id'])) {
            return $this->_guidance['id'];
        }

        return '';
    }

    /**
     * Is the version downloadable
     *
     * @return bool
     */
    public function isDownload() {
        return !!$this->_download;
    }

    /**
     * Get the version HD
     *
     * @return bool
     */
    public function isHD() {
        return !!$this->_hd;
    }

    /**
     * Get the slug of the version.
     * This can be used in URLs for episode playback
     *
     * @return string
     */
    public function getSlug() {
        switch ($this->_kind) {
            case 'signed':
                $slug = 'sign';
                break;
            case 'audio-described':
                $slug = 'ad';
                break;
            default:
                $slug = '';
        }
        return $slug;
    }
}
