<?php

class BBC_Service_Bamboo_Models_VersionTest extends PHPUnit_Framework_TestCase
{
    public function testSlugForOriginalVersion() {
        $version = $this->_createVersion(array('kind' => 'original'));
        $this->assertEquals('', $version->getSlug());
    }

    public function testSlugForSignedVersion() {
        $version = $this->_createVersion(array('kind' => 'signed'));
        $this->assertEquals('sign', $version->getSlug());
    }

    public function testSlugForAudioDescribedVersion() {
        $version = $this->_createVersion(array('kind' => 'audio-described'));
        $this->assertEquals('ad', $version->getSlug());
    }

    public function testSlugForOtherVersions() {
        $version = $this->_createVersion(array('kind' => 'other'));
        $this->assertEquals('', $version->getSlug());
    }

    public function testRetrievingOnwardJourneyTime() {
        $version = $this->_createVersion(
            array('event' =>
                array('kind' => 'onward_journey', 'time_offset_seconds' => '30'))
        );

        $timeOffset = '';
        foreach ($version as $event) {
            if ($event->kind === 'onward_journey') {
                // @codingStandardsIgnoreStart
                $timeOffset = $event->time_offset_seconds;
                // @codingStandardsIgnoreEnd
            }
        }
        $this->assertEquals($timeOffset, $version->getOnwardJourneyTime());
    }

    public function testGuidanceData() {
        $version = $this->_createVersion(
            array('guidance' => array(
                'text' => (object) array(
                    'small' => 'small text',
                    'medium' => 'medium text',
                    'large' => 'large text'
                )
            ))
        );
        $this->assertEquals('small text', $version->getSmallGuidance());
        $this->assertEquals('medium text', $version->getMediumGuidance());
        $this->assertEquals('large text', $version->getLargeGuidance());
    }

    public function testEmptyGuidanceData() {
        $version = $this->_createVersion(array());
        $this->assertEquals('', $version->getSmallGuidance());
        $this->assertEquals('', $version->getMediumGuidance());
        $this->assertEquals('', $version->getLargeGuidance());
    }

    private function _createVersion($params) {
        return new BBC_Service_Bamboo_Models_Version((object) $params);
    }
}
