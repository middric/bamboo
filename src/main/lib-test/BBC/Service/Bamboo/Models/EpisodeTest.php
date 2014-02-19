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

    public function testSlugWithQuestionMark()
    {
        $episode = $this->_createEpisode(array('title' => 'Question mark?'));
        $this->assertEquals('question-mark', $episode->getSlug());
        $episode = $this->_createEpisode(array('title' => 'Question', 'subtitle' => 'mark?'));
        $this->assertEquals('question-mark', $episode->getSlug());
    }

    public function testSlugWithApostrophe() {
        $episode = $this->_createEpisode(array('title' => 'What\'s the craic', 'subtitle' => 'jack?'));
        $this->assertEquals('whats-the-craic-jack', $episode->getSlug());
    }

    public function testSlugWithMixedCaseTitle() {
        $episode = $this->_createEpisode(array('title' => 'MyTiTlE'));
        $this->assertEquals('mytitle', $episode->getSlug());
    }

    public function testSlugWithAccentedTitle() {
        $episode = $this->_createEpisode(array('title' => 'MÿTītłę'));
        $this->assertEquals('mytitle', $episode->getSlug());

        $episode = $this->_createEpisode(array('title' => "An L\xc3\xa0"));
        $this->assertEquals('an-la', $episode->getSlug());
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

    public function testEmpttyTleoType() {
        $episode = $this->_createEpisode(array());
        $this->assertEquals('', $episode->getTleoType());
    }

    public function testTleoType() {
        $episode = $this->_createEpisode(array('tleo_type' => 'brand'));
        $this->assertEquals('brand', $episode->getTleoType());
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

    public function testPriorityVersionWithBlankPreference() {
        $versions = $this->_createVersions(array('signed', 'audio-described'));
        $episode = $this->_createEpisode(array('versions' => $versions));
        $priorityVersion = $episode->getPriorityVersion('');
        // It should return the first version instead
        $this->assertEquals('signed', $priorityVersion->getKind());
    }

    public function testPriorityVersionWithNoVersions() {
        $episode = $this->_createEpisode(array('title' => 'My Title'));
        $priorityVersion = $episode->getPriorityVersion();
        $this->assertEquals('', $priorityVersion);
    }

    public function testPriorityVersionSlugCallsPriorityVersion() {
        $stub = $this->getMockBuilder('BBC_Service_Bamboo_Models_Episode')
            ->setMethods(array('getPriorityVersion'))
            ->disableOriginalConstructor()
            ->getMock();

        $stub->expects($this->once())
            ->method('getPriorityVersion');

        $stub->getPriorityVersionSlug();
    }

    public function testPriorityVersionSlugPassesPreferenceToPriorityVersion() {
        $stub = $this->getMockBuilder('BBC_Service_Bamboo_Models_Episode')
            ->setMethods(array('getPriorityVersion'))
            ->disableOriginalConstructor()
            ->getMock();

        $stub->expects($this->once())
            ->method('getPriorityVersion')
            ->with('signed');

        $stub->getPriorityVersionSlug('signed');
    }

    public function testPriorityVersionSlugReturnsVersionSlug() {
        $version = $this->getMockBuilder('BBC_Service_Bamboo_Models_Version')
            ->setMethods(array('getSlug'))
            ->disableOriginalConstructor()
            ->getMock();

        $episode = $this->getMockBuilder('BBC_Service_Bamboo_Models_Episode')
            ->setMethods(array('getPriorityVersion'))
            ->disableOriginalConstructor()
            ->getMock();

        $episode->expects($this->once())
            ->method('getPriorityVersion')
            ->will($this->returnValue($version));

        $version->expects($this->once())
            ->method('getSlug')
            ->will($this->returnValue('slug'));

        $this->assertEquals('slug', $episode->getPriorityVersionSlug());
    }

    public function testPriorityVersionSlugReturnsBlankWithNoVersion() {
        $stub = $this->getMockBuilder('BBC_Service_Bamboo_Models_Episode')
            ->setMethods(array('getPriorityVersion'))
            ->disableOriginalConstructor()
            ->getMock();

        $stub->expects($this->once())
            ->method('getPriorityVersion')
            ->will($this->returnValue(''));

        $this->assertEquals('', $stub->getPriorityVersionSlug());
    }

    public function testGetDurationReturnsPriorityVersionDuration() {
        $version = new BBC_Service_Bamboo_Models_Version((object) array('duration' => array('text' => '40 mins')));
        $stub = $this->getMockBuilder('BBC_Service_Bamboo_Models_Episode')
            ->setMethods(array('getPriorityVersion'))
            ->disableOriginalConstructor()
            ->getMock();

        $stub->expects($this->once())
            ->method('getPriorityVersion')
            ->will($this->returnValue($version));

        $this->assertEquals('40 mins', $stub->getDuration());
    }

    public function testGetDurationReturnsBlankWhenNoVersionPresent() {
        $stub = $this->getMockBuilder('BBC_Service_Bamboo_Models_Episode')
            ->setMethods(array('getPriorityVersion'))
            ->disableOriginalConstructor()
            ->getMock();

        $stub->expects($this->once())
            ->method('getPriorityVersion')
            ->will($this->returnValue(''));

        $this->assertEquals('', $stub->getDuration());
    }

    public function testGetMasterBrandAttribution() {
        $episode = $this->_createEpisode(
            array(
                'master_brand' => array(
                    'attribution' => 'bbc_two_wales'
                 )
            )
        );
        $this->assertEquals('bbc_two_wales', $episode->getMasterBrandAttribution());
    }

    public function testGetRelatedLinks() {
        $related = $this->_createVersions(array('priority_content', 'external'));
        $episode = $this->_createEpisode(array('related_links' => $related));
        $links = $episode->getRelatedLinks();
        $this->assertNotEmpty($links);
        $this->assertInstanceOf(
            'BBC_Service_Bamboo_Models_Related',
            $links[0]
        );
    }

    public function testGetFirstRelatedLink() {
        $related = $this->_createVersions(array('priority_content', 'external'));
        $episode = $this->_createEpisode(array('related_links' => $related));
        $link = $episode->getFirstRelatedLink();
        $this->assertInstanceOf(
            'BBC_Service_Bamboo_Models_Related',
            $link
        );
    }

    public function testHasDownloads() {
        $downloadable = $this->_createEpisode(array('versions' => $this->_createVersions(array('original'))));
        $notDownloadable = $this->_createEpisode(array('versions' => $this->_createVersions(array('original'), false)));
        $this->assertTrue($downloadable->hasDownloads());
        $this->assertFalse($notDownloadable->hasDownloads());
    }

    private function _createEpisode($params) {
        return new BBC_Service_Bamboo_Models_Episode((object) $params);
    }

    private function _createVersions($kinds, $downloadable = true) {
        $versions = array();
        foreach ($kinds as $kind) {
            $versions[] = (object) array('kind' => $kind, 'download' => $downloadable);
        }
        return $versions;
    }
}
