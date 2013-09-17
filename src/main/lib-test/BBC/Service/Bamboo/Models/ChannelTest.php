<?php

class BBC_Service_Bamboo_Models_ChannelTest extends PHPUnit_Framework_TestCase
{
    public function testUnregionalisedID() {
        $channel = $this->_createChannel(array('id' => 'bbc_one_london'));
        $this->assertEquals('bbc_one', $channel->getUnregionalisedID());
    }

    private function _createChannel($params) {
        return new BBC_Service_Bamboo_Models_Channel((object) $params);
    }
}
