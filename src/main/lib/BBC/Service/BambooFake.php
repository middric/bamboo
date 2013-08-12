<?php
/**
 * BBC_Service_BambooFake
 *
 * A fail state bamboo
 *
 * @category BBC
 * @package BBC_Service_Bamboo
 * @copyright Copyright (c) 2007 - 2009 BBC (http://www.bbc.co.uk)
 * @author Rich Middleditch <richard.middleditch1@bbc.co.uk>
 */

class BBC_Service_BambooFake extends BBC_Service_Bamboo
{
    /**
     * @BBC_Service_Bamboo_Client_Fail
     */
    protected $_client = null;

    protected static $_paths;

    protected static $_keywords;


    public function __construct(array $parameters = array()) {
        parent::__construct($parameters);
        $this->_client = new BBC_Service_Bamboo_Client_Fake(
            $this->_configuration->getConfiguration()->httpmulti,
            self::$_keywords,
            self::$_paths
        );
    }

    /**
     *  Adds a keyword to the matchstick client which will fail any requests which have as a
     *  substring these keywords
     *
     * @param array $keywords
     */
    public static function addKeywords(array $keywords) {
        foreach ($keywords as $keyword) {
            if ($keyword != "") {
                self::$_keywords[] = explode('@', $keyword);
            }
        }
    }

    /**
     *  Adds a path on the file system to the fixtures directory
     */
    public static function addPath($path) {
        self::$_paths[] = $path;
    }

    public function fetch($feedName, $params) {
        $params = parent::_prepareParams($params);
        $response = $this->_client->get($feedName, $params);

        $json = json_decode($response->getBody());
        $factory = new BBC_Service_Bamboo_ModelFactory($json);
        $built = $factory->build();

        return $built;
    }

    /**
     *  Resets keywords
     */
    public static function clearKeywords() {
        self::$_keywords = array();
    }
}
