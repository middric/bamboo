<?php

class BBC_Service_Bamboo_Models_ChannelTest extends PHPUnit_Framework_TestCase
{
    public function testUnregionalisedID() {
        $channel = $this->_createChannel(array('id' => 'bbc_one_london'));
        $this->assertEquals('bbc_one', $channel->getUnregionalisedID());
    }

    public function testGetSlug() {
        $bbcone = $this->_createChannel(array('id' => 'bbc_one_london'));
        $bbctwo = $this->_createChannel(array('id' => 'bbc_two_england'));
        $bbcthree = $this->_createChannel(array('id' => 'bbc_three'));
        $bbcfour = $this->_createChannel(array('id' => 'bbc_four'));
        $cbbc = $this->_createChannel(array('id' => 'cbbc'));
        $cbeebies = $this->_createChannel(array('id' => 'cbeebies'));
        $bbcnews = $this->_createChannel(array('id' => 'bbc_news24'));
        $bbcparliament = $this->_createChannel(array('id' => 'bbc_parliament'));
        $bbcalba = $this->_createChannel(array('id' => 'bbc_alba'));
        $this->assertEquals('bbcone', $bbcone->getSlug());
        $this->assertEquals('bbctwo', $bbctwo->getSlug());
        $this->assertEquals('bbcthree', $bbcthree->getSlug());
        $this->assertEquals('bbcfour', $bbcfour->getSlug());
        $this->assertEquals('cbbc', $cbbc->getSlug());
        $this->assertEquals('cbeebies', $cbeebies->getSlug());
        $this->assertEquals('bbcnews', $bbcnews->getSlug());
        $this->assertEquals('bbcparliament', $bbcparliament->getSlug());
        $this->assertEquals('bbcalba', $bbcalba->getSlug());
    }

    public function testCBBCIsChildrens() {
        $channel = $this->_createChannel(array('id' => 'cbbc'));
        $this->assertTrue($channel->isChildrens());
    }

    public function testCbeebiesIsChildrens() {
        $channel = $this->_createChannel(array('id' => 'cbeebies'));
        $this->assertTrue($channel->isChildrens());
    }

    public function testBBCOneIsNotChildrens() {
        $channel = $this->_createChannel(array('id' => 'bbc_one'));
        $this->assertFalse($channel->isChildrens());
    }

    private function _createChannel($params) {
        return new BBC_Service_Bamboo_Models_Channel((object) $params);
    }
}
