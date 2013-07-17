<?php
/**
 * BBC_Service_Bamboo_Models_Episode
 *
 *
 * @category BBC
 * @package BBC_Service_Bamboo_Models
 * @author Craig Taub <craig.taub@bbc.co.uk>
 * @copyright Copyright (c) 2013 BBC (http://www.bbc.co.uk)
 */
class BBC_Service_Bamboo_Models_Episode extends BBC_Service_Bamboo_Models_Element
{
    protected $_subtitle = "";
    // @codingStandardsIgnoreStart
    protected $_release_date = "";
    protected $_tleo_id = "";
    // @codingStandardsIgnoreEnd
    protected $_versions = array();
    protected $_film = false;
    protected $_duration = "";
    protected $_href = "";
    protected $_labels = array();
    protected $_stacked = "";
    protected $_guidance = "";
    protected $_credits = "";

    /**
     * Get the episode subtitle
     * 
     * @return string
     */
    public function getSubtitle() {
        return $this->_subtitle;
    }

    /**
     * Get the episode TLEO pid
     * 
     * @return string
     */
    public function getTleoId() {
        // @codingStandardsIgnoreStart
        return $this->_tleo_id;
        // @codingStandardsIgnoreEnd
    }

    /**
     * Get the editorial label
     * 
     * @return string
     */
    public function getEditorialLabel() {
        if (isset($this->_labels['editorial'])) {
            return $this->_labels['editorial'];
        }
        return "";
    }

    /**
     * Get the timeliness label
     * 
     * @return string
     */
    public function getTimelinessLabel() {
        if (isset($this->_labels['time'])) {
            return $this->_labels['time'];
        }
        return "";
    }

    /**
     * Get the release date 
     * 
     * @return string
     */
    public function getReleaseDate() {
        // @codingStandardsIgnoreStart
        return $this->_release_date;
        // @codingStandardsIgnoreEnd
    }

    /**
     * Get the duration
     * 
     * @return string|DateInterval
     */
    public function getDuration() {
        if ($this->_duration) {
            return new DateInterval($this->_duration);
        }

        return "";
    }

    /**
     * Is the episode a film
     * 
     * @return bool
     */
    public function isFilm() {
        return !!$this->_film;
    }

    /**
     * Get the versions attached to this episode. Returns an array of {@link BBC_Service_Bamboo_Models_Version} objects
     * 
     * @return array
     */
    public function getVersions() {
        return $this->_versions;
    }

    /**
     * Gets the original version attached to the episode
     * 
     * @return string|BBC_Service_Bamboo_Models_Version
     */
    public function getOriginalVersion() 
    {
        if (isset($this->_versions[0])) {
            return $this->_versions[0];
        } 
        return "";
    }

    /**
     * Get the episode HREF
     * 
     * @return string
     */
    public function getHref() {
        return $this->_href;
    }

    /**
     * Get the complete title for the episode. This is a combination of episode title and subtitle
     * 
     * @return string
     */
    public function getCompleteTitle() {
        return $this->_title . ($this->_subtitle ? ' - ' . $this->_subtitle : '');
    }

    /**
     * Get a URL safe title for the episode
     * 
     * @return string
     */
    public function getURLSafeTitle() {
        return mb_strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $this->getCompleteTitle()));
    }

    public function getCredits() {
        return $this->_credits;
    }
}
