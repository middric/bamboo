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
        $versions = $mockedObject->getVersions();
        $firstVersion = $versions[0];

        $this->assertEquals(get_class($firstVersion), 'BBC_Service_Bamboo_Models_Version');
    }

    public function testSetPropertySubtitle() {
        $mockedObject = $this->_mockedObject;

        $this->assertEquals($mockedObject->getSubtitle(), 'Series 3 - Episode 1');
    }

    public function testSetPropertyTleoId() {
        $mockedObject = $this->_mockedObject;
        // @codingStandardsIgnoreStart
        $this->assertEquals($mockedObject->getTleoId(), 'b00vk2lp');
        // @codingStandardsIgnoreEnd
    }

    public function testSetVersionsSetPropertyId() {
        $mockedObject = $this->_mockedObject;
        $versions = $mockedObject->getVersions();
        $firstVersion = $versions[0];

        $this->assertEquals($firstVersion->getId(), 'b036y9g5');
    }

    private function _mockEpisode($response) {
        return new EpisodeMock($response);
    }

}

class ElementMock extends BBC_Service_Bamboo_Models_Base
{
    protected $_type = '';
    protected $_synopses = array();
    protected $_images = array();
    // @codingStandardsIgnoreStart
    protected $_master_brand = array();
    // @codingStandardsIgnoreEnd
}

class EpisodeMock extends ElementMock
{
    protected $_subtitle = "";
    // @codingStandardsIgnoreStart
    protected $_release_date = "";
    protected $_tleo_id = "";
    // @codingStandardsIgnoreEnd
    protected $_versions = array();
    protected $_film = false;
    protected $_duration = "";
    protected $_href = "";
    protected $_labels = array();
    protected $_stacked = "";
    protected $_guidance = "";
    protected $_credits = "";

    public function getSubtitle() {
        return $this->_subtitle;
    }

    public function getTleoId() {
        // @codingStandardsIgnoreStart
        return $this->_tleo_id;
        // @codingStandardsIgnoreStart
    }

    public function getVersions() {
        return $this->_versions;
    }
}

