<?php
class BBC_Service_Bamboo_Models_BaseTest extends PHPUnit_Framework_TestCase
{

    protected $_mockedObject;
    
    protected function setUp() {
        $episodeResponse = Zend_Http_Response::fromString(
            file_get_contents(dirname(__FILE__) . '/../../../../fixtures/episodes_p01b2b5c.json')
        );
        $response = json_decode($episodeResponse->getBody());
        $this->_mockedObject = $this->_mockEpisode($response->episodes[0]);  
    }

    public function testSetVersions() {
        $mockedObject = $this->_mockedObject;
        $firstVersion = $mockedObject->_versions[0];

        $this->assertEquals(get_class($firstVersion), 'BBC_Service_Bamboo_Models_Version' );
    }

    public function testSetPropertySubtitle() {
        $mockedObject = $this->_mockedObject;

        $this->assertEquals($mockedObject->_subtitle, 'Series 3 - Episode 1' );
    }

    public function testSetPropertyTleoId() {
        $mockedObject = $this->_mockedObject;

        $this->assertEquals($mockedObject->_tleo_id, 'b00vk2lp' );
    }

    public function testSetVersionsSetPropertyId() {
        $mockedObject = $this->_mockedObject;
        $firstVersion = $mockedObject->_versions[0];

        $this->assertEquals($firstVersion->getId(), 'b036y9g5' );
    }

    private function _mockEpisode($response) {
        return new EpisodeMock($response);
    }

}

class ElementMock extends BBC_Service_Bamboo_Models_Base
{
    public $_type = '';
    public $_synopses = array();
    public $_images = array();
    // @codingStandardsIgnoreStart
    public $_master_brand = array();
    // @codingStandardsIgnoreEnd
}

class EpisodeMock extends ElementMock
{
    public $_subtitle = "";
    // @codingStandardsIgnoreStart
    public $_release_date = "";
    public $_tleo_id = "";
    // @codingStandardsIgnoreEnd
    public $_versions = array();
    public $_film = false;
    public $_duration = "";
    public $_href = "";
    public $_labels = array();
    public $_stacked = "";
    public $_guidance = "";
    public $_credits = "";
}

