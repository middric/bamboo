<?php

/**
 * BBC_Service_Matchstick_Client_NitroMock
 *
 * A class representing our mocked Nitro client
 *
 * @category BBC
 * @package BBC_Service_Bamboo
 * @copyright Copyright (c) 2007 - 2012 BBC (http://www.bbc.co.uk)
 * @author Luke Sands <luke.sands@bbc.co.uk>
 */
class BBC_Service_Bamboo_Client_HttpMultiMock
    extends BBC_Service_Bamboo_Client_HttpMulti
{

    /**
     * A list of faked responses we want to use
     * @var array
     */
    protected $_fakeResponses = array();

    /**
     * Returns the http client
     *
     * @return BBC_Http_Multi_Client
     */
    public function getHttpClient() {
        // Get the http client from the parent
        $httpClient = parent::getHttpClient();
        // Set the adaptor
        $httpClient->setAdapter($this->_getHttpMultiAdapterMock());
        return $httpClient;
    }

    /**
     * Returns the adapter mock for the BBC_Http_Multi_Client
     *
     * @return BBC_Http_Multi_Client
     */
    protected function _getHttpMultiAdapterMock() {
        $adapter = new BBC_Http_Multi_Client_Adapter_Mock();
        foreach ($this->_fakeResponses as $fakeResponse) {
            list($url, $request) = $fakeResponse;
            $adapter->addResponse($url, $request);
        }
        return $adapter;
    }

    /**
     * Add a fixtured response to the http multi client
     *
     * @param string $url
     * @param string $fixturePath
     *
     * @return  boolean true if successful
     */
    public function addResponseFromPath($url, $file) {
        if (file_exists($file) == true) {
            // Load our sample JSON response
            $contents = file_get_contents($file);
            $response = Zend_Http_Response::fromString($contents);
            $this->addResponse($url, $response);
            return true;
        }
        return false;
    }

    /**
     * Adds a fixtured response to the http multi client
     *
     * @param string $url
     * @param Zend_Http_Response $response
     */
    public function addResponse($url, $response) {
        $this->_fakeResponses[] = array($url, $response);
    }

}