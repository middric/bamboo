<?php

/**
 * BBC_Service_Bamboo_DataSource
 *
 * Bamboo class for retrieving data from Bamboo
 *
 * @package      BBC_Service_Bamboo
 * @author          Craig Taub <craig.taub@bbc.co.uk>
 * @copyright       Copyright (c) 2013 BBC (http://www.bbc.co.uk)
 */
class BBC_Service_Bamboo_DataSource
{
    /**
     * @var BBC_Service_Bamboo
     */
    protected $_bamboo = null;

    /**
     * Configuration object
     * @var Zend_Config
     */
    protected $_config = null;

    /**
     * Whether to use stubs or not, uses bamboo.stubBaseUrl if true
     * Defaults to not use stubs
     * WARNING: The cache IS NOT varied on whether it's a stub,
     *     so wait for expiration or restart memcache if you change this
     * @var boolean
     */
    protected $_isUsingStubs = false;


    /**
     * Fetch a single bamboo request
     *
     * @param  $feedName string, $params array
     * @return BBC_Service_Matchstick_Response The response
     */
    public function fetch($feedName, $params = array()) {

        try {
            $response = $this->getBamboo()->fetch($feedName, $params);
        } catch (BBC_Service_Bamboo_Exception_BadRequest $e) {
            BBC_Tviplayer_CounterFactory::increment(BBC_Tviplayer_CounterFactory::BAMBOO_BADREQUEST);
            throw $e;
        } catch (BBC_Service_Bamboo_Exception_NotFound $e) {
            BBC_Tviplayer_CounterFactory::increment(BBC_Tviplayer_CounterFactory::BAMBOO_NOTFOUND);
            throw $e;
        } catch (BBC_Service_Bamboo_Exception_MethodNotAllowed $e) {
            BBC_Tviplayer_CounterFactory::increment(BBC_Tviplayer_CounterFactory::BAMBOO_METHODNOTALLOWED);
            throw $e;
        } catch (BBC_Service_Bamboo_Exception_InternalServerError $e) {
            BBC_Tviplayer_CounterFactory::increment(BBC_Tviplayer_CounterFactory::BAMBOO_SERVERERROR);
            throw $e;
        } catch (BBC_Service_Bamboo_Exception_Unauthorised $e) {
            BBC_Tviplayer_CounterFactory::increment(BBC_Tviplayer_CounterFactory::BAMBOO_UNAUTHORISED);
            throw $e;
        } catch (BBC_Service_Bamboo_Exception $e) { // All other errors
            BBC_Tviplayer_CounterFactory::increment(BBC_Tviplayer_CounterFactory::BAMBOO_OTHER);
            $message = sprintf('Failed to get data from Bamboo feed %s [%s]', $feedName, $e->getMessage());
            BBC_Tviplayer_Log::error($message);
            throw new BBC_Tviplayer_Exception_DataError_Bamboo($message, 500, $e);
        }

        if (!is_object($response) || empty($response)) {
            throw new BBC_Tviplayer_Exception_EmptyFeed('Response empty', 500);
        }
        return $response;
    }

    /**
     * Return the Configuration object
     * @return Zend_Config
     */
    protected function getConfig() {
        if (!($this->_config instanceof Zend_Config)) {
            $this->setConfig(BBC_Tviplayer_Util::getAppConfiguration());
        }
        return $this->_config;
    }

    /**
     * Set the configuration object
     * @param Zend_Config $config The configuration object to use
     */
    public function setConfig(Zend_Config $config) {
        $this->_config = $config->bamboo;

        return $this->_config;
    }

    /**
     * Retrieve the instance of Bamboo to use, if not set creates the default
     *
     * @return BBC_Service_Bamboo
     */
    public function getBamboo() {
        if (!($this->_bamboo instanceof BBC_Service_Bamboo)) {
            $this->setBamboo(BBC_Service_Broker::getInstance()->build('bamboo'));
        }
        return $this->_bamboo;
    }

    /**
     * Set the Bamboo instance to use
     *
     * @param BBC_Service_Bamboo $instance Instance of an Bamboo
     */
    public function setBamboo(BBC_Service_Bamboo $instance) {
        $this->_bamboo = $instance;

        // Setup Bamboo configuration
        $config = $this->getConfig();
        $baseUrl = $this->getUseStubs() ? $config->baseStubUrl : $config->baseUrl;
        $this->_bamboo->setAPIKey($config->key);
        $this->_bamboo->setBaseURL($baseUrl);
        $this->_bamboo->setHost($config->host);

        // Setupd Bamboo logger
        $logger = BBC_Tviplayer_Log::getLogger();
        BBC_Service_Bamboo_Log::setLogger($logger);
        return $this->_bamboo;
    }

    /**
     * Get the base URL if we have a bamboo instance, blank string if not
     * @return string
     */
    public function getBaseUrl() {
        if ($this->_bamboo !== null) {
            return $this->_bamboo->getBaseUrl();
        }
        return '';
    }

    /**
     * returns whether we're using stubs or not
     * @return boolean
     */
    public function getUseStubs() {
        return $this->_isUsingStubs;
    }

    /**
     * Set whether or not to use config.baseStubUrl or config.baseUrl
     * This will call setBaseUrl on the underlying instance
     *     so it can be switched between `fetch`s
     * @return boolean the new value of _isUsingStubs
     */
    public function setUseStubs($val) {
        $this->_isUsingStubs = (bool)$val;
        if ($this->_bamboo !== null) {
            $config = $this->getConfig();
            $url = $this->_isUsingStubs ? $config->baseStubUrl : $config->baseUrl;
            $this->_bamboo->setBaseUrl($url);
        }
    }
}
