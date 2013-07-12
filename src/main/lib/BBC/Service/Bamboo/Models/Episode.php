<?php
/**
 * BBC_Service_Bamboo_Models_Episode
 *
 *
 * @category BBC
 * @package BBC_Service
 * @subpackage BBC_Service_Bamboo_Models
 * @author Craig Taub <craig.taub@bbc.co.uk>
 * @copyright Copyright (c) 2013 BBC (http://www.bbc.co.uk)
 */
class BBC_Service_Bamboo_Models_Episode extends BBC_Service_Bamboo_Models_Element
{
    protected $_subtitle = "";
    protected $_release_date = "";
    protected $_tleo_id = "";
    protected $_versions = array();
    protected $_film = false;
    protected $_duration = "";
    protected $_href = "";
    protected $_labels = array();
    protected $_stacked = "";
    protected $_guidance = "";
    protected $_credits = "";

    public function getSubtitle() {
        return $this->_subtitle;
    }

    public function getTleoId() {
        return $this->_tleo_id;
    }

    public function getEditorialLabel()
    {
        if (isset($this->_labels['editorial'])) {
            return $this->_labels['editorial'];
        }
        return "";
    }

    public function getTimelinessLabel()
    {
        if (isset($this->_labels['time'])) {
            return $this->_labels['time'];
        }
        return "";
    }

    public function getReleaseDate()
    {
        if ($this->_release_date) {
            return new DateTime($this->_release_date);
        }

        return "";
    }

    public function getDuration()
    {
        if ($this->_duration) {
            return new DateInterval($this->_duration);
        }

        return "";
    }

    public function isFilm()
    {
        return !!$this->_film;
    }

    public function getVersions()
    {
        return $this->_versions;
    }

    public function getHref() {
        return $this->_href;
    }

    public function getCompleteTitle() {
        return $this->_title . ($this->_subtitle ? ' - ' . $this->_subtitle : '');
    }

    public function getURLSafeTitle() {
        return mb_strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $this->getCompleteTitle()));
    }

    public function getCredits() {
        return $this->_credits;
    }
}