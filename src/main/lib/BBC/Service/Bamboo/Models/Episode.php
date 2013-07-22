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
     * Gets the version with highest priority attached to the episode. A preference can be provided to override the
     * default. If the preference is not found then the default will be returned instead.
     *
     * @param string $preference a specific version to look for
     *
     * @return string|BBC_Service_Bamboo_Models_Version
     */
    public function getPriorityVersion($preference = null)
    {
        if (isset($this->_versions[0])) {
            $result = $this->_versions[0];
            if ($preference) {
                foreach ($this->_versions as $version) {
                    if ($version->getKind() === $preference) {
                        $result = $version;
                    }
                }
            }
            return $result;
        }
        return "";
    }

    /**
     * Gets the priority version and returns its slug. If no version exists it returns an empty string. An optional
     * preference can be specified in which case the version of that kind will be returned if it exists, else the
     * version with highest priority is returned.
     *
     * @param string $preference a specific version to return
     *
     * @return string
     */
    public function getPriorityVersionSlug($preference = null) {
        $version = $this->getPriorityVersion($preference);

        if ($version) {
            return $version->getSlug();
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
     * Get a hyphenated slug of the title and subtitle
     *
     * @return string
     */
    public function getSlug() {
        $processedTitle = trim($this->_unaccent($this->getCompleteTitle()));
        return mb_strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $processedTitle));
    }

    public function getCredits() {
        return $this->_credits;
    }

    // Convert accented characters to their 'normal' alternative
    private function _unaccent($string) {
        return iconv('UTF-8', 'ASCII//TRANSLIT', $string);
    }
}
