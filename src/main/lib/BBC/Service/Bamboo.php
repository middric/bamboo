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
     * @var BBC_Service_Bamboo_Cache
     */
    protected $_cache;
    /**
     * @var BBC_Service_Bamboo_Configuration
     */
    protected $_configuration;
    /**
     * @var BBC_Service_Bamboo_Client
     */
    protected $_client;
    /**
     * @var String api key
     */
    protected $_apiKey;

    /**
     * Construct a new BBC_Service_Bamboo
     *
     * @param $text
     * @return void
     */
    public function __construct(array $params = array()) {
        $this->_configuration = new BBC_Service_Bamboo_Configuration($params);
        $this->_cache = new BBC_Service_Bamboo_Cache($this->_configuration->getConfiguration()->cache);
        $this->setClient(new BBC_Service_Bamboo_Client_HttpMulti($this->_configuration->getConfiguration()->httpmulti));
        
        if (class_exists('BBC_Tviplayer_Monitoring_StatsD')) {
            BBC_Tviplayer_Monitoring_StatsD::setConfig($this->_configuration->getConfiguration()->statsd);
        }
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

        $response = $this->_cache->get($feedName, $params);
        if (!$response) {
            $response = $this->_client->get($feedName, $params);
            $this->_cache->save($feedName, $params, $response);
        }

        $json = json_decode($response->getBody());

        return $json;
    }

    public function fetch($feedName, $params = array()) {
        $json = $this->getJson($feedName, $params);
        $factory = new BBC_Service_Bamboo_ModelFactory($json);
        $built = $factory->build();

        return $built;
    }

    public function setAPIKey($apiKey) {
        BBC_Service_Bamboo_Log::info("API Key set to $apiKey");
        $this->_apiKey = $apiKey;
    }

    public function setLanguage($language) {
        BBC_Service_Bamboo_Log::info("Accept-Language set to $language");
        $this->_client->setHeader('Accept-Language', $language);
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
        $params = array_merge(array('api_key' => $this->_apiKey, 'rights'=>'web'), $params);
        ksort($params);
        return $params;
    }

}
