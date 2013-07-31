<?php
/**
 * BBC_Service_BambooFail
 *
 * A fail state bamboo
 *
 * @category BBC
 * @package BBC_Service_Bamboo
 * @copyright Copyright (c) 2007 - 2009 BBC (http://www.bbc.co.uk)
 * @author Rich Middleditch <richard.middleditch1@bbc.co.uk>
 */

class BBC_Service_BambooFail extends BBC_Service_Bamboo
{
    /**
     * @BBC_Service_Bamboo_Client_Fail
     */
    protected $_client = null;

    protected static $_keywords = array();


    public function __construct(array $parameters = array()) {
        parent::__construct($parameters);
        $this->_client = new BBC_Service_Bamboo_Client_Fail(
            $this->_configuration->getConfiguration()->httpmulti,
            self::$_keywords
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
            if ($keyword != "")
                self::$_keywords[] = $keyword;
        }
    }

    public function fetch($feedName, $params = array()) {
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
