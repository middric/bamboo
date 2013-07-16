<?php

class BBC_Service_ModelFactoryTest extends PHPUnit_Framework_TestCase
{

    /**
     * Runs the test methods of this class.
     *
     * @access public
     * @static
     */
    public function main() {
        require_once 'PHPUnit/TextUI/TestRunner.php';

        $suite = new PHPUnit_Framework_TestSuite('BBC_Service_ModelFactoryTest');
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
    }

    public function testAddsRootParameter() {
        $zendResponse = Zend_Http_Response::fromString(
            file_get_contents(dirname(__FILE__) . '/../../fixtures/status.json')
        );
        $response = json_decode($zendResponse->getBody());
        $factory = new BBC_Service_Bamboo_ModelFactory($response);
        $factory->build();

        $this->assertEquals('status', $factory->getRoot());
    }

    public function testStripsUnnecessaryParameter() {
        $zendResponse = Zend_Http_Response::fromString(
            file_get_contents(dirname(__FILE__) . '/../../fixtures/status.json')
        );
        $response = json_decode($zendResponse->getBody());
        $factory = new BBC_Service_Bamboo_ModelFactory($response);
        $factory->build();
        $strippedResponse = $factory->getResponse();

        $this->assertFalse(isset($strippedResponse->version));
        $this->assertFalse(isset($strippedResponse->schema));
        $this->assertFalse(isset($strippedResponse->timestamp));

        // Check these is only one root element in the stripped response;
        $this->assertEquals(1, count($strippedResponse));
    }

    /**
     * @expectedException BBC_Service_Bamboo_Exception_EmptyFeed
     */
    public function testThrowsEmptyFeedError() {
        $zendResponse = Zend_Http_Response::fromString(
            file_get_contents(dirname(__FILE__) . '/../../fixtures/empty.json')
        );
        $response = json_decode($zendResponse->getBody());
        $factory = new BBC_Service_Bamboo_ModelFactory($response);
        $factory->build();
        $strippedResponse = $factory->getResponse();
    }

    public function testReturnsEmptyArrayWhenElementsIsEmpty() {
        $zendResponse = Zend_Http_Response::fromString(
            file_get_contents(dirname(__FILE__) . '/../../fixtures/no_elements.json')
        );
        $response = json_decode($zendResponse->getBody());
        $factory = new BBC_Service_Bamboo_ModelFactory($response);
        $elements = $factory->build();
        $this->assertTrue($elements->isEmpty());
    }

    public function testContainsEpisodesFromAFeedWithElements() {
        $zendResponse = Zend_Http_Response::fromString(
            file_get_contents(dirname(__FILE__) . '/../../fixtures/episodes_p01b2b5c_recommendations.json')
        );
        $response = json_decode($zendResponse->getBody());
        $factory = new BBC_Service_Bamboo_ModelFactory($response);
        $elements = $factory->build();

        foreach ($elements as $value) {
            $this->assertEquals('BBC_Service_Bamboo_Models_Episode', get_class($value));
        }
    }

    public function testContainsEpisodesFromAFeedWithoutElements() {
        $zendResponse = Zend_Http_Response::fromString(
            file_get_contents(dirname(__FILE__) . '/../../fixtures/episodes_p01b2b5c.json')
        );
        $response = json_decode($zendResponse->getBody());
        $factory = new BBC_Service_Bamboo_ModelFactory($response);
        $elements = $factory->build();

        foreach ($elements as $value) {
            $this->assertEquals('BBC_Service_Bamboo_Models_Episode', get_class($value));
        }
    }

    /*public function testContainsMixtureOfModels() {
        $zendResponse = Zend_Http_Response::fromString(
            file_get_contents(dirname(__FILE__) . '/../../fixtures/channels_bbc_one_highlights.json')
        );
        $response = json_decode($zendResponse->getBody());
        $factory = new BBC_Service_Bamboo_ModelFactory($response);
        $elements = $factory->build();

        foreach ($elements as $value) {
            $this->assertTrue(
                in_array(get_class($value), array(
                    'BBC_Service_Bamboo_Models_Episode',
                    'BBC_Service_Bamboo_Models_Programme'
                ))
            );
        }
    }*/
}

