<?php

/**
 * BBC_Service_Bamboo_Client
 *
 * Client class for iBL
 *
 * @category BBC
 * @package BBC_Service_Bamboo
 * @copyright Copyright (c) 2007 - 2013 BBC (http://www.bbc.co.uk)
 * @author Jak Spalding
 */
class BBC_Service_Bamboo_Client_HttpMulti
    implements BBC_Service_Bamboo_Client_Interface
{
    /**
     * @var Zend_Config
     */
    protected $_config;
    /**
     * The HTTP client to use (if any)
     * @var BBC_Http_Multi_Client
     */
    protected $_httpClient;

    protected $_headers = array();

    /**
     * @param $config Zend_Config configuration for the client
     */
    public function __construct($config) {
        $this->_config = $config;
        $this->setHeader('User-Agent', $this->_config->useragent);
    }

    /**
     *
     * @param $path
     * @param array $params
     * @return array
     */
    public function get($path, array $params = array()) {
        $url = $this->_buildURL($path, $params);
        BBC_Service_Bamboo_Log::debug("Requesting $url");
        $options = array(
            'headers' => $this->getHeaders()
        );
        $response = null;
        $client = $this->getHttpClient();
        $client->get($path, $options)->then(
            function ($myResponse) use (&$response) {
                $response = $myResponse;
            }
        )->end();
        $client->run();

        return $path;
    }

    /**
     * Allow setting of the HTTP client, for testing purposes
     *
     * @param BBC_Http_Multi_Client $client
     */
    public function setHttpClient(BBC_Http_Multi_Client $client) {
        $this->_httpClient = $client;
    }

    /**
     * Returns a new http client, or one previously set by setHttpClient()
     *
     * @return BBC_Http_Multi_Client
     */
    public function getHttpClient() {
        // If a client has previously been set, return that.
        if (isset($this->_httpClient)) {
            return $this->_httpClient;
        }

        // Set the http multi client content cache property if required
        if ($this->_config->contentCaching == true) {
            BBC_Http_Multi_Client_Factory::setCache(
                BBC_Webapp_Base::getInstance()->getContentCache()
            );
        }
        // Create a new http multi client from the factory
        $httpClient = BBC_Http_Multi_Client_Factory::build();
        // Set the max execution time
        $httpClient->setExecutionTimeout(
            $this->_config->timeout
        );

        return $httpClient;
    }

    public function setHost($host) {
        $this->_host = $host;
    }

    public function setBaseURL($baseURL) {
        $this->_baseURL = $baseURL;
    }

    public function setHeader($name, $value) {
        $this->_headers[$name] = $value;
    }

    public function getHeaders() {
        return $this->_headers;
    }

    private function _buildURL($path, array $params) {
        $queryString = http_build_query($params);
        $url = $this->_host . $this->_baseURL . $path . '?' . $queryString;
        if(!filter_var($url, FILTER_VALIDATE_URL,
            FILTER_FLAG_PATH_REQUIRED | FILTER_FLAG_QUERY_REQUIRED)) {
            throw new BBC_Service_Bamboo_Exception_BadRequest("iBL URL is bad: $url");
        }
        return $url;
    }
}