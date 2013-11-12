<?php 
class BBC_Service_Bamboo_Models_ElementTest extends PHPUnit_Framework_TestCase
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
     * Using an Element Mock
     */
    public function testGetType() {
        $mockedElement = $this->_mockElement();

        $this->assertEquals($mockedElement->getType(), 'episode_large');
    }

    public function testGetShortSynopsis() {
        $mockedElement = $this->_mockElement(); 

        $this->assertEquals(
            $mockedElement->getShortSynopsis(),
            'Luther investigates two horrific cases, unaware his every step is under scrutiny.'
        );
    }

    public function testGetMasterBrand() {
        $mockedElement = $this->_mockElement(); 

        $this->assertEquals($mockedElement->getMasterBrand(), 'BBC Two');
    }

    public function testGetImage() {
        $mockedElement = $this->_mockElement(); 

        $this->assertEquals(
            $mockedElement->getImage(),
            'http://ichef.live.bbci.co.uk/images/ic/336x581/legacy/episode/p01b2b5c.jpg'
        );
    }

    /* 
     * Using an Episode Mock and inheritance
     */
    public function testGetEpisodeType() {
        $mockedEpisode = $this->_mockEpisode(); 

        $this->assertEquals($mockedEpisode->getType(), 'episode_large');
    }

    public function testGetEpisodeMasterBrandAttribution() {
        $mockedEpisode = $this->_mockEpisode(); 

        $this->assertEquals($mockedEpisode->getMasterBrandAttribution(), 'bbc_two');
    }

    public function testGetEpisodeImageRecipe() {
        $mockedEpisode = $this->_mockEpisode(); 

        $this->assertEmpty($mockedEpisode->getImageRecipe('vertical'));
    }

    private function _mockEpisode() {
        return new EpisodeMock($this->_responseEpisode);
    }

    private function _mockElement() {
        return new BBC_Service_Bamboo_Models_Element($this->_responseEpisode);
    }
}

class EpisodeMock extends BBC_Service_Bamboo_Models_Element
{
}