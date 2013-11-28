<?php
class BBC_Service_Bamboo_Models_BaseTest extends PHPUnit_Framework_TestCase
{
    /*
    * We use a mocked Base object here
    */
    public function testGetId() {
        $params = array('id'=>'p01b2b5c');
        $base = $this->_createBase($params);

        $this->assertEquals($base->getId(), 'p01b2b5c');
    }

    public function testGetResponse() {
        $params = array('response'=> (object) array());
        $base = $this->_createBase($params);

        $this->assertEquals(get_class($base->getResponse()), 'stdClass');
    }

    /*
     * SetVersions and NOT getVersions as checking Base SetVersions() runs as expected.
     * Using a mocked Episode object.
     */
    public function testSetVersions() {
        $params = array('versions' => array(0 => array('id' => 'b036y9g5')));
        $mockedEpisode = $this->_mockEpisode($params);
        $versions = $mockedEpisode->getVersions();
        $firstVersion = $versions[0];

        $this->assertEquals(get_class($firstVersion), 'BBC_Service_Bamboo_Models_Version');
    }

    public function testSetPropertySubtitle() {
        $params = array('subtitle' => 'Series 3 - Episode 1');
        $mockedEpisode = $this->_mockEpisode($params);

        $this->assertEquals($mockedEpisode->getSubtitle(), 'Series 3 - Episode 1');
    }

    public function testSetPropertyTleoId() {
        $params = array('tleo_id' => 'b00vk2lp');
        $mockedEpisode = $this->_mockEpisode($params);

        $this->assertEquals($mockedEpisode->getTleoId(), 'b00vk2lp');
    }

    public function testSetVersionsSetPropertyId() {
        $params = array('versions' => array(0 => (object) array('id' => 'b036y9g5')));
        $mockedEpisode = $this->_mockEpisode($params);
        $versions = $mockedEpisode->getVersions();
        $firstVersion = $versions[0];

        $this->assertEquals($firstVersion->getId(), 'b036y9g5');
    }

    private function _mockEpisode($params) {
        return new BBC_Service_Bamboo_Models_Episode((object) $params);
    }

    private function _createBase($params) {
        return new BBC_Service_Bamboo_Models_Base((object) $params);
    }

}
