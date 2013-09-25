<?php

class BBC_Service_Bamboo_Models_ChannelTest extends PHPUnit_Framework_TestCase
{
    public function testUnregionalisedID() {
        $channel = $this->_createChannel(array('id' => 'bbc_one_london'));
        $this->assertEquals('bbc_one', $channel->getUnregionalisedID());
    }

    public function testCBBCRequiresParentalGuidance() {
        $channel = $this->_createChannel(array('id' => 'cbbc'));
        $this->assertTrue($channel->requiresParentalGuidance());
    }

    public function testCbeebiesRequiresParentalGuidance() {
        $channel = $this->_createChannel(array('id' => 'cbeebies'));
        $this->assertTrue($channel->requiresParentalGuidance());
    }

    public function testOnlyChildrensChannelsRequireParentalGuidance() {
        $channel = $this->_createChannel(array('id' => 'another_channel'));
        $this->assertFalse($channel->requiresParentalGuidance());
    }

    private function _createChannel($params) {
        return new BBC_Service_Bamboo_Models_Channel((object) $params);
    }
}
