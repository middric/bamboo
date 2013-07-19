<?php

class BBC_Service_Bamboo_Models_EpisodeTest extends PHPUnit_Framework_TestCase
{
    public function testSlugWithEmptyTitle() {
        $episode = $this->_createEpisode(array('title' => ''));
        $this->assertEquals('', $episode->getSlug());
    }

    public function testSlugWithSingleWordTitle() {
        $episode = $this->_createEpisode(array('title' => 'title'));
        $this->assertEquals('title', $episode->getSlug());
    }

    public function testSlugWithTitleContainingDigits() {
        $episode = $this->_createEpisode(array('title' => '90210'));
        $this->assertEquals('90210', $episode->getSlug());
    }

    public function testSlugWithMultiWordTitle() {
        $episode = $this->_createEpisode(array('title' => 'my title'));
        $this->assertEquals('my-title', $episode->getSlug());
    }

    public function testSlugWithTabbedTitle() {
        $episode = $this->_createEpisode(array('title' => "my\ttitle"));
        $this->assertEquals('my-title', $episode->getSlug());
    }

    public function testSlugWithMultiSpaceTitle() {
        $episode = $this->_createEpisode(array('title' => "my    title  has    many    spaces"));
        $this->assertEquals('my-title-has-many-spaces', $episode->getSlug());
    }

    public function testSlugWithLeadingSpaces() {
        $episode = $this->_createEpisode(array('title' => '  my', 'subtitle' => '   subtitle'));
        $this->assertEquals('my-subtitle', $episode->getSlug());
    }

    public function testSlugWithTrailingSpaces() {
        $episode = $this->_createEpisode(array('title' => 'my  ', 'subtitle' => 'subtitle   '));
        $this->assertEquals('my-subtitle', $episode->getSlug());
    }

    public function testSlugWithMixedCaseTitle() {
        $episode = $this->_createEpisode(array('title' => 'MyTiTlE'));
        $this->assertEquals('mytitle', $episode->getSlug());
    }

    public function testSlugWithAccentedTitle() {
        $episode = $this->_createEpisode(array('title' => 'MÿTītłę'));
        $this->assertEquals('mytitle', $episode->getSlug());
    }

    public function testSlugWithSubtitle() {
        $episode = $this->_createEpisode(array('title' => 'title', 'subtitle' => 'subtitle'));
        $this->assertEquals('title-subtitle', $episode->getSlug());
    }

    public function testSlugWithAccentedSubtitle() {
        $episode = $this->_createEpisode(array('title' => 'èvéry', 'subtitle' => 'thïng'));
        $this->assertEquals('every-thing', $episode->getSlug());
    }

    public function testSlugWithLongTitleAndSubtitle() {
        $episode = $this->_createEpisode(
            array(
                'title' => "  The Longer\t  \tThë tîtle\t\t   ",
                'subtitle' => "\t  the more hypheñs\t \t \t"
            )
        );
        $this->assertEquals('the-longer-the-title-the-more-hyphens', $episode->getSlug());
    }

    public function testPriorityVersionWithMultipleVersions() {
        $versions = $this->_createVersions(array('original', 'audio-described', 'signed', 'other'));
        $episode = $this->_createEpisode(array('versions' => $versions));
        $priorityVersion = $episode->getPriorityVersion();
        $this->assertEquals('original', $priorityVersion->getKind());
    }

    public function testPriorityVersionWithSingleVersion() {
        $versions = $this->_createVersions(array('signed'));
        $episode = $this->_createEpisode(array('versions' => $versions));
        $priorityVersion = $episode->getPriorityVersion();
        $this->assertEquals('signed', $priorityVersion->getKind());
    }

    public function testPriorityVersionWithPreferenceThatExists() {
        $versions = $this->_createVersions(array('original', 'signed'));
        $episode = $this->_createEpisode(array('versions' => $versions));
        $priorityVersion = $episode->getPriorityVersion('signed');
        $this->assertEquals('signed', $priorityVersion->getKind());
    }

    public function testPriorityVersionWithPreferenceThatDoesntExist() {
        $versions = $this->_createVersions(array('signed', 'other'));
        $episode = $this->_createEpisode(array('versions' => $versions));
        $priorityVersion = $episode->getPriorityVersion('audio-described');
        // It should return the first version instead
        $this->assertEquals('signed', $priorityVersion->getKind());
    }

    public function testPriorityVersionWithNoVersions() {
        $episode = $this->_createEpisode(array('title' => 'My Title'));
        $priorityVersion = $episode->getPriorityVersion();
        $this->assertEquals('', $priorityVersion);
    }

    private function _createEpisode($params) {
        return new BBC_Service_Bamboo_Models_Episode((object) $params);
    }

    private function _createVersions($kinds) {
        $versions = array();
        foreach ($kinds as $kind) {
            $versions[] = (object) array('kind' => $kind);
        }
        return $versions;
    }
}
