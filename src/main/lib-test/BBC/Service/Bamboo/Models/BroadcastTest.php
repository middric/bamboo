<?php
class BBC_Service_Bamboo_Models_BroadcastTest extends PHPUnit_Framework_TestCase
{
    public function testTypeExists() {
        $params = array(
            'type' => 'broadcast'
        );
        $broadcast = $this->_createBroadcast($params);

        $this->assertEquals('broadcast', $broadcast->getType());
    }

    public function testStartEndTimeExists() {
        $params = array(
            'start_time' => '2013-04-09T16:00:00Z',
            'end_time' => '2013-04-09T17:00:00Z'
        );
        $broadcast = $this->_createBroadcast($params);

        $this->assertEquals('2013-04-09T16:00:00Z', $broadcast->getStartTime());
        $this->assertEquals('2013-04-09T17:00:00Z', $broadcast->getEndTime());
    }

    public function testEpisodeType() {
        $params = array(
            'type' => 'broadcast',
            'episode' => (object) array('type'=>'episode', 'title' => 'title', 'subtitle' => 'subtitle')
        );
        $broadcast = $this->_createBroadcast($params);

        $this->assertEquals('BBC_Service_Bamboo_Models_Episode', get_class($broadcast->getEpisode()));
    }

    private function _createBroadcast($params) {
        return new BBC_Service_Bamboo_Models_Broadcast((object) $params);
    }

}
