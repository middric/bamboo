<?php

class BBC_Service_BambooTest extends PHPUnit_Framework_TestCase
{

    protected $_service;

    /**
     * Runs the test methods of this class.
     *
     * @access public
     * @static
     */
    public function main() {
        require_once 'PHPUnit/TextUI/TestRunner.php';

        $suite = new PHPUnit_Framework_TestSuite('BBC_Service_BambooTest');
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }

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

        $this->_service->setHost('http://hostname.com');
        $this->_service->setBaseURL('/baseurl/');
        $this->_service->setAPIKey(1);
    }

    /**
     * Test that bamboo returns a bamboo service object
     */
    public function testBambooService() {
        $this->assertEquals('BBC_Service_BambooMock', get_class($this->_service));
    }

    /**
     * Test that bamboo can fetch data
     */
    public function testFetch() {
        $fixture = dirname(__FILE__) . '/../../fixtures/status.json';
        $this->_service->getClient()->addResponseFromPath(
            'http://hostname.com/baseurl/status.json?api_key=1&rights=web',
            $fixture
        );
        $response = $this->_service->fetch('status', array());

        $this->assertEquals('BBC_Service_Bamboo_ResponseArrayObject', get_class($response));

    }

    /**
     * Test that bamboo can fetch data with a query string appended to it
     */
    public function testQueryFetch() {
        $fixture = dirname(__FILE__) . '/../../fixtures/status.json_page_1';
        $this->_service->getClient()->addResponseFromPath(
            'http://hostname.com/baseurl/status.json?api_key=1&page=1&rights=web',
            $fixture
        );
        $response = $this->_service->fetch('status', array('page' => '1'));

        $this->assertEquals('BBC_Service_Bamboo_ResponseArrayObject', get_class($response));
        $this->assertObjectHasAttribute('build_version', $response);
    }

    public function testSetLanguage() {
        $fixture = dirname(__FILE__) . '/../../fixtures/status.json';
        $this->_service->setLanguage('cy');

        $this->_service->getClient()->addResponseFromPath(
            'http://hostname.com/baseurl/status.json?api_key=1&lang=cy&rights=web',
            $fixture
        );
        $response = $this->_service->fetch('status', array());
        $this->assertEquals('BBC_Service_Bamboo_ResponseArrayObject', get_class($response));
        $this->assertObjectHasAttribute('build_version', $response);
    }


}

