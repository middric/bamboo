<?php
/**
 * BBC_Service_Bamboo
 *
 * A service class for iBL
 *
 * @category BBC
 * @package BBC_Service
 * @copyright Copyright (c) 2007 - 2013 BBC (http://www.bbc.co.uk)
 * @author
 */

class BBC_Service_Bamboo implements BBC_Service_Interface
{
    /**
     * @var BBC_Service_Bamboo_Configuration
     */
    protected $_configuration;
    /**
     * @var BBC_Service_Bamboo_Client
     */
    protected $_client;
    /**
     * @var array stores the default parameters for each request, including api_key
     */
    protected $_defaultParameters = array('rights' => 'web', 'lang' => 'en');

    /**
     * Construct a new BBC_Service_Bamboo
     *
     * @param $text
     * @return void
     */
    public function __construct(array $params = array()) {
        $this->_configuration = new BBC_Service_Bamboo_Configuration($params);
        $this->setClient(new BBC_Service_Bamboo_Client_HttpMulti($this->_configuration->getConfiguration()->httpmulti));
    }

    /**
     * Returns the name of the service
     *
     * @return string
     */
    public static function getName() {
        return 'bamboo';
    }

    /**
     * Returns the class version
     *
     * @return string
     */
    public static function getVersion() {
        return '0.1.0';
    }

    public function getClient() {
        return $this->_client;
    }

    public function setClient($client) {
        $this->_client = $client;
    }

    /**
     * Returns a NEW instance of the class
     * TODO: make singleton to reduce memory impact?
     * @param array $params  Parameters received from BBC_Service_Broker
     * @return BBC_Service_Bamboo
     */
    public static function getInstance(array $params = array()) {
        $calledClass = get_called_class();
        return new $calledClass($params);
    }

    public function getJson($feedName, $params = array()) {
        $params = $this->_prepareParams($params);
        $response = $this->_client->get($feedName, $params);
        return $response->getBody();
    }

    public function fetch($feedName, $params = array()) {
        $json = $this->getJson($feedName, $params);
        $objects = json_decode($json);
        $factory = new BBC_Service_Bamboo_ModelFactory($objects);
        $built = $factory->build();

        return $built;
    }

    public function setAPIKey($apiKey) {
        BBC_Service_Bamboo_Log::info("API Key set to $apiKey");
        $this->_defaultParameters['api_key'] = $apiKey;
    }

    public function setLanguage($language) {
        BBC_Service_Bamboo_Log::info("Setting language to $language");
        $this->_defaultParameters['lang'] = $language;
    }

    public function getLanguage() {
        return $this->_defaultParameters['lang'];
    }

    public function setHost($host) {
        $this->_client->setHost($host);
    }

    public function setBaseURL($baseURL) {
        $this->_client->setBaseURL($baseURL);
    }

    public function getBaseURL() {
        return $this->_client->getBaseURL();
    }

    protected function _prepareParams($params) {
        $params = array_merge($this->_defaultParameters, $params);
        ksort($params);
        return $params;
    }

}
