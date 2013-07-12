<?php

/**
 * BBC_Service_Matchstick_Client_NitroTest
 *
 * Tests for the Bamboo client for HTTPMulti
 *
 * @category BBC
 * @package BBC_Service_Bamboo
 * @copyright Copyright (c) MMXII BBC (http://www.bbc.co.uk)
 * @author Rich Middleditch <richard.middleditch1@bbc.co.uk>
 */
class BBC_Service_Bamboo_Client_HttpMultiTest extends PHPUnit_Framework_TestCase
{
    private $_service;
    private $_client;
    private $_host = 'http://hostname';
    private $_base = '/baseurl/';
    private $_suffix = '.json?api_key=1';

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp() {
        $appCacheBackend = new Zend_Cache_Backend_Apc();
        $appCacheFront = new Zend_Cache_Core(
            array(
                'cache_id_prefix' => 'bamboo',
                'lifetime' => 3600,
                'automatic_serialization' => true
            )
        );
        $appCacheFront->setBackend($appCacheBackend);
        BBC_Service_Broker::setCache($appCacheFront);
        BBC_Service_Broker::getInstance()->registerService('bamboo', 'BBC_Service_BambooMock', true);

        $this->_service = BBC_Service_Broker::getInstance()->build('bamboo');
        $this->_client = $this->_service->getClient();
    }

    /**
     * Test that Http Multi is returned
     */
    public function testHttpMultiClient() {
        $httpMulti = $this->_client->getHttpClient();

        $this->assertEquals('BBC_Http_Multi_Client', get_class($httpMulti));
    }

    /**
     * Test URL generation
     */
    public function testURLSet() {
        $this->_client->setHost('http://hostname.com');
        $this->_client->setBaseURL('/baseurl/');
        $url = $this->_client->buildURL('test', array('api_key' => 1));

        $this->assertEquals('http://hostname.com/baseurl/test.json?api_key=1', $url);
    }

    /**
     * Test that the correct headers are set
     */
    public function testHeaderSet() {
        $key = 'key';
        $value = 'value';
        $this->_client->setHeader($key, $value);

        $headers = $this->_client->getHeaders();
        $this->assertArrayHasKey($key, $headers);
        $this->assertEquals($value, $headers[$key]);
    }

    /**
     * Test a mocked request
     */
    public function testGet() {
        $feed = 'status';
        $fixture = dirname(__FILE__) . '/../../../fixtures/' . $feed . '.json';

        $this->_client->setHost($this->_host);
        $this->_client->setBaseURL($this->_base);
        $this->_client->addResponseFromPath($this->_host . $this->_base . $feed . $this->_suffix, $fixture);

        $response = $this->_client->get($feed, array('api_key' => 1));

        $this->assertEquals('Zend_Http_Response', get_class($response));
        $body = json_decode($response->getBody());
        $this->assertObjectHasAttribute('status', $body);
    }

    /**
     * Test exceptions
     */
    public function testException(){
        $feed = 'error';
        $fixture = dirname(__FILE__) . '/../../../fixtures/' . $feed . '.json';

        $this->_client->setHost($this->_host);
        $this->_client->setBaseURL($this->_base);
        $this->_client->addResponseFromPath($this->_host . $this->_base . $feed . $this->_suffix, $fixture);

        $this->setExpectedException('BBC_Service_Bamboo_Exception_InternalServerError');
        $response = $this->_client->get($feed, array('api_key' => 1));
    }
}