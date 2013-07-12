<?php
/**
 * BBC_Service_Bamboo_Models_Promotion
 *
 *
 * @category BBC
 * @package BBC_Service
 * @subpackage BBC_Service_Bamboo_Models
 * @author Craig Taub <craig.taub@bbc.co.uk>
 * @copyright Copyright (c) 2013 BBC (http://www.bbc.co.uk)
 */
class BBC_Service_Bamboo_Models_Promotion
{

    private $_id;
    private $_title;
    private $_subtitle;
    private $_synopsis;
    private $_episode = array();

    /**
     * @param stdClass $response
     * Constructor setting up instance vars for object instance
     */
    public function __construct($response) {
        $this->_id = $response->id;
        $this->_title = $response->title;
        $this->_subtitle = $response->subtitle;
        $this->_synopsis = new BBC_Service_Bamboo_Models_Synopsis($response);
        foreach ($response->episode as $episode) {
            $this->_episode[] = new BBC_Service_Bamboo_Models_Episode($episode);
        }
    }   

    /**
     * Returns the id of the episode
     * @return string
     */
    public function getId() {
        return $this->_id;
    }

    /**
     * Returns the title of the episode
     * @return string
     */
    public function getTitle() {
        return $this->_title;
    }

    /**
     * Returns the subtitle of the episode
     * @return string
     */
    public function getSubtitle() {
        return $this->_subtitle;
    }

    /**
     * Returns the Short synopsis from Synopsis object
     * @return string
     */
    public function getSynopsisShort() {
        return $this->_synopsis->getSynopsis('short');
    }

    /**
     * Returns array of episode objects
     * @return array
     */
    public function getEpisodesArray() {
        // @codingStandardsIgnoreStart
        return $this->_initial_child_episodes;
        // @codingStandardsIgnoreEnd
    }

}