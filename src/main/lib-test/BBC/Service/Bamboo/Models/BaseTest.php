<?php
class BBC_Service_Bamboo_Models_BaseTest extends PHPUnit_Framework_TestCase
{

/*
    public function testEpisodeType() {
        $params = array(
            'type' => 'broadcast',
            'episode' => (object) array('type'=>'episode', 'title' => 'title', 'subtitle' => 'subtitle')
        );
        $broadcast = $this->_createBroadcast($params);

        $this->assertInstanceOf('BBC_Service_Bamboo_Models_Episode', $broadcast->getEpisode());
    }

    private function _createBroadcast($params) {
        return new BBC_Service_Bamboo_Models_Base((object) $params);
    }

*/

/*
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
*/

    public function testOne() {
        /*
        $params = array(
            'type' => 'broadcast',
            'episode' => (object) array('type'=>'episode', 'title' => 'title', 'subtitle' => 'subtitle')
        );
        */
        $zendResponse = Zend_Http_Response::fromString(
            file_get_contents(dirname(__FILE__) . '/../../../../fixtures/episodes_p01b2b5c.json')
        );
        $response = json_decode($zendResponse->getBody());

        $mockObject = $this->_mockObject($response);

        //WRONG...check what ModelFactory does and replicate.

die;
        var_dump($mockObject);die;
//die;
        $this->assertEquals('', '' );
        //$this->assertEquals('BBC_Service_BambooMock', get_class($this->_service));
    }

    private function _mockObject($response) {
        //$new = new MockClass($params);
        //var_dump($new);die;
        return new MockClass($response);
        //return new BBC_Service_Bamboo_Models_Category((object) $params);
    }


}

class MockClass extends BBC_Service_Bamboo_Models_Base
{

}