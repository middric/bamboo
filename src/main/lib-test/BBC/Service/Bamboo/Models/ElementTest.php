<?php 
class BBC_Service_Bamboo_Models_ElementTest extends PHPUnit_Framework_TestCase
{
    /* 
     * Using an Element Mock
     */
    public function testGetType() {
        $params = array('type' => 'episode_large');
        $element = $this->_createElement($params);

        $this->assertEquals($element->getType(), 'episode_large');
    }


    public function testGetShortSynopsis() {
        $params = array('synopses' => array('small' =>
                'Luther investigates two horrific cases, unaware his every step is under scrutiny.')
        );
        $element = $this->_createElement($params); 

        $this->assertEquals(
            $element->getShortSynopsis(),
            'Luther investigates two horrific cases, unaware his every step is under scrutiny.'
        );
    }

    public function testGetMasterBrand() {
        // @codingStandardsIgnoreStart
        $params =  array('master_brand' => array('titles' => (object) array('small' => 'BBC Two')));
        // @codingStandardsIgnoreStart
        $element = $this->_createElement($params); 

        $this->assertEquals($element->getMasterBrand(), 'BBC Two');
    }

    public function testGetImage() {
        $params = array('images' => 
            array('standard' => 'http://ichef.live.bbci.co.uk/images/ic/{recipe}/legacy/episode/p01b2b5c.jpg')
        );
        $element = $this->_createElement($params); 

        $this->assertEquals(
            $element->getImage(),
            'http://ichef.live.bbci.co.uk/images/ic/336x581/legacy/episode/p01b2b5c.jpg'
        );
    }

    /* 
     * Using an Episode Mock and inheritance
     */
    public function testGetEpisodeType() {
        $params =  array('type'=>'episode_large');
        $mockedEpisode = $this->_mockEpisode($params); 

        $this->assertEquals($mockedEpisode->getType(), 'episode_large');
    }

    public function testGetEpisodeMasterBrandAttribution() {
        $params =  array('master_brand' => array('attribution'=>'bbc_two'));
        $mockedEpisode = $this->_mockEpisode($params); 

        $this->assertEquals($mockedEpisode->getMasterBrandAttribution(), 'bbc_two');
    }

    public function testGetEpisodeImageRecipe() {
        $params = array();
        $mockedEpisode = $this->_mockEpisode($params); 

        $this->assertEmpty($mockedEpisode->getImageRecipe('vertical'));
    }

    public function testFetchStatus() {
        $episode = $this->_createEpisode(array('status' => 'unavailable'));
        $this->assertEquals('unavailable', $episode->getStatus());
    }

    public function testIsComingSoon() {
        $episode = $this->_createEpisode(array('status' => 'unavailable'));
        $this->assertEquals(true, $episode->isComingSoon());

        $episode = $this->_createEpisode(array('status' => 'available'));
        $this->assertEquals(false, $episode->isComingSoon());
    }

    private function _mockEpisode($params) {
        return new BBC_Service_Bamboo_Models_Episode((object) $params);
    }

    private function _createElement($params) {
        return new BBC_Service_Bamboo_Models_Element((object) $params);
    }
}
