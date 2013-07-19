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

    private function _createVersion($params) {
        return new BBC_Service_Bamboo_Models_Version((object) $params);
    }
}
