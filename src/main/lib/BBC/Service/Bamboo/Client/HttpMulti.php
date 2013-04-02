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

    /**
     * @param $config Zend_Config configuration for the client
     */
    public function __construct($config) {
        $this->_config = $config;
    }

    public function get($path) {
        $options = array(
            'headers' => array(
                'User-Agent' => $this->_config->useragent
            )
        );
        $response = null;
        $client = $this->getHttpClient();
        $client->get($path, $options)->then(function ($myResponse) use (&$response) {
            $response = $myResponse;
        })->end();
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

    /**
     * Returns the user agent to be used for all requests
     *
     * @return string
     */
    public function getUserAgent() {
        if (isset($this->_config->useragent) == true) {
            return $this->_config->useragent;
        } else if (isset($_SERVER['PAL_WEBAPP']) == true) {
            return $_SERVER['PAL_WEBAPP'];
        }
        return null;
    }

    public function setHost($host) {

    }

    public function setBaseURL($baseURL) {

    }
}