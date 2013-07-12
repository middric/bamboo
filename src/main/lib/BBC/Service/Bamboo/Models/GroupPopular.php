<?php
/**
 * BBC_Service_Bamboo_Models_GroupPopular
 *
 *
 * @category BBC
 * @package BBC_Service
 * @subpackage BBC_Service_Bamboo_Models
 * @author Craig Taub <craig.taub@bbc.co.uk>
 * @copyright Copyright (c) 2013 BBC (http://www.bbc.co.uk)
 */
class BBC_Service_Bamboo_Models_GroupPopular
{

   /**
     * @var Episode id
     */
	private $_id;

    /**
     * @var Episode title string
     */
	private $_title;

    /**
     * @var Episode subtitle string
     */
	private $_subtitle;

    /**
     * @var Synopsis Object
     */
	private $_synopsis;

    /**
     * @var episodes array.
     */
	private $_initial_child_episodes = array();

	/**
     * @var Limit on items in a group
     */
	const MAX_ITEMS_IN_GROUP = 5;

    /**
     * @param stdClass $response
     * Constructor setting up instance vars for object instance
     */
	public function __construct($response) {
		$this->_id = $response->id;
		$this->_title = $response->title;
		$this->_subtitle = $response->subtitle;
		$this->_synopsis = new BBC_Service_Bamboo_Models_Synopsis($response);
		foreach($response->initial_child_episodes as $episode){
			$this->_initial_child_episodes[] = new BBC_Service_Bamboo_Models_Episode($episode);
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
		return $this->_initial_child_episodes;
	}

    /**
     * Returns count of episodes
     * @return array
     */
	public function getChildEpisodeCount() {
		return count($this->_initial_child_episodes);
	}

	/**
     * Returns array of episodes limited by number in Constant var
     * @return array
     */
	public function getVisibleEpisodesArray() {
		return array_slice($this->_initial_child_episodes, 0 , self::MAX_ITEMS_IN_GROUP);
	}
}