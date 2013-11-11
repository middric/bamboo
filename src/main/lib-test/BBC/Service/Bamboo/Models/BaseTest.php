<?php
class BBC_Service_Bamboo_Models_BaseTest extends PHPUnit_Framework_TestCase
{
    protected $_responseEpisode;

    protected function setUp() {
        $response = Zend_Http_Response::fromString(
            file_get_contents(dirname(__FILE__) . '/../../../../fixtures/episodes_p01b2b5c.json')
        );
        $responseObject = json_decode($response->getBody());
        $this->_responseEpisode = $responseObject->episodes[0];
    }

    /*
    * We use a mocked Base object here
    */
    public function testGetId() {
        $mockedBase = $this->_mockBase();

        $this->assertEquals($mockedBase->getId(), 'p01b2b5c');
    }

    public function testGetResponse() {
        $mockedBase = $this->_mockBase();

        $this->assertEquals(get_class($mockedBase->getResponse()), 'stdClass');
    }

    /*
     * SetVersions and NOT getVersions as checking Base SetVersions() runs as expected.
     * Using a mocked Episode object.
     */
    public function testSetVersions() {
        $mockedEpisode = $this->_mockEpisode();
        $versions = $mockedEpisode->getVersions();
        $firstVersion = $versions[0];

        $this->assertEquals(get_class($firstVersion), 'BBC_Service_Bamboo_Models_Version');
    }

    public function testSetPropertySubtitle() {
        $mockedEpisode = $this->_mockEpisode();

        $this->assertEquals($mockedEpisode->getSubtitle(), 'Series 3 - Episode 1');
    }

    public function testSetPropertyTleoId() {
        $mockedEpisode = $this->_mockEpisode();
        // @codingStandardsIgnoreStart
        $this->assertEquals($mockedEpisode->getTleoId(), 'b00vk2lp');
        // @codingStandardsIgnoreEnd
    }

    public function testSetVersionsSetPropertyId() {
        $mockedEpisode = $this->_mockEpisode();
        $versions = $mockedEpisode->getVersions();
        $firstVersion = $versions[0];

        $this->assertEquals($firstVersion->getId(), 'b036y9g5');
    }

    private function _mockEpisode() {
        return new EpisodeMock($this->_responseEpisode);
    }

    private function _mockBase() {
        return new BBC_Service_Bamboo_Models_Base($this->_responseEpisode);
    }

}

class EpisodeMock extends BBC_Service_Bamboo_Models_Base
{
    protected $_type = '';
    protected $_synopses = array();
    protected $_images = array();
    // @codingStandardsIgnoreStart
    protected $_master_brand = array();
    // @codingStandardsIgnoreEnd

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

