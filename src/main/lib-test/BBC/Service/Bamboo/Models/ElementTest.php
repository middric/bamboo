<?php
class BBC_Service_Bamboo_Models_ElementTest extends PHPUnit_Framework_TestCase
{

    const SECONDS_IN_A_YEAR = 31536000;
    const SECONDS_IN_A_WEEK = 604800;
    const SECONDS_IN_A_DAY = 86400;

    /*
     * Using an Element Mock
     */
    public function testGetType() {
        $params = array('type' => 'episode_large');
        $element = $this->_createElement($params);

        $this->assertEquals($element->getType(), 'episode_large');
    }


    public function testGetShortSynopsis() {
        $params = array('synopses' => array('small' =>
                'Luther investigates two horrific cases, unaware his every step is under scrutiny.')
        );
        $element = $this->_createElement($params);

        $this->assertEquals(
            $element->getShortSynopsis(),
            'Luther investigates two horrific cases, unaware his every step is under scrutiny.'
        );
    }

    public function testGetMasterBrand() {
        // @codingStandardsIgnoreStart
        $params =  array('master_brand' => array('titles' => (object) array('small' => 'BBC Two')));
        // @codingStandardsIgnoreStart
        $element = $this->_createElement($params);

        $this->assertEquals($element->getMasterBrand(), 'BBC Two');
    }

    public function testGetImage() {
        $params = array('images' =>
            array('standard' => 'http://ichef.live.bbci.co.uk/images/ic/{recipe}/legacy/episode/p01b2b5c.jpg')
        );
        $element = $this->_createElement($params);

        $this->assertEquals(
            $element->getImage(),
            'http://ichef.live.bbci.co.uk/images/ic/336x581/legacy/episode/p01b2b5c.jpg'
        );
    }

    /*
     * Using an Episode Mock and inheritance
     */
    public function testGetEpisodeType() {
        $params =  array('type'=>'episode_large');
        $mockedEpisode = $this->_mockEpisode($params);

        $this->assertEquals($mockedEpisode->getType(), 'episode_large');
    }

    public function testGetEpisodeMasterBrandAttribution() {
        $params =  array('master_brand' => array('attribution'=>'bbc_two'));
        $mockedEpisode = $this->_mockEpisode($params);

        $this->assertEquals($mockedEpisode->getMasterBrandAttribution(), 'bbc_two');
    }

    public function testGetEpisodeImageRecipe() {
        $params = array();
        $mockedEpisode = $this->_mockEpisode($params);

        $this->assertEmpty($mockedEpisode->getImageRecipe('vertical'));
    }

    public function testFetchStatus() {
        $episode = $this->_createElement(array('status' => 'unavailable'));
        $this->assertEquals('unavailable', $episode->getStatus());
    }

    public function testIsComingSoon() {
        $episode = $this->_createElement(array('status' => 'unavailable'));
        $this->assertEquals(true, $episode->isComingSoon());

        $episode = $this->_createElement(array('status' => 'available'));
        $this->assertEquals(false, $episode->isComingSoon());
    }

    /* Testing dates like 6pm 24 Feb 2014 */
    public function testIsFutureDateHour() {
        $hourAgoDate = date('ha d M Y', time() - 3600);
        $this->_testIsFuture($hourAgoDate, false);

        $inAnHourDate = date('ha d M Y', time() + 3600);
        $this->_testIsFuture($inAnHourDate, true);

        $yesterdayDate = date('ha d M Y', time() - self::SECONDS_IN_A_DAY);
        $this->_testIsFuture($yesterdayDate, false);

        $tomorrowDate = date('ha d M Y', time() + self::SECONDS_IN_A_DAY);
        $this->_testIsFuture($tomorrowDate, true);

        $nowDate = date('ha d M Y', time());
        $this->_testIsFuture($nowDate, false);
    }


    /* Testing dates like 24 Feb 2014 */
    public function testIsFutureDate() {
        $todayDate = date('d M Y', time());
        $this->_testIsFuture($todayDate, false);

        $tomorrowDate = date('d M Y', time() + self::SECONDS_IN_A_DAY);
        $this->_testIsFuture($tomorrowDate, true);

        $nextWeekDate = date('d M Y', time() + self::SECONDS_IN_A_WEEK);
        $this->_testIsFuture($nextWeekDate, true);

        $pastWeekDate = date('d M Y', time() - self::SECONDS_IN_A_WEEK);
        $this->_testIsFuture($pastWeekDate, false);

        $pastYearDate = date('d M Y', time() - self::SECONDS_IN_A_YEAR);
        $this->_testIsFuture($pastYearDate, false);

        $nextYearDate = date('d M Y', time() + self::SECONDS_IN_A_YEAR);
        $this->_testIsFuture($nextYearDate, true);
    }

    /* Testing dates like Feb 2014 */
    public function testIsFutureDateMonthYear() {
        $nextMonthDate = date('M Y', time() + self::SECONDS_IN_A_WEEK * 4.5);
        $this->_testIsFuture($nextMonthDate, true);

        $pastMonthDate = date('M Y', time() - self::SECONDS_IN_A_WEEK * 4.5);
        $this->_testIsFuture($pastMonthDate, false);

        $thisMonthDate = date('M Y', time());
        $this->_testIsFuture($thisMonthDate, false);
    }

    /* Testing dates like 2014 */
    public function testIsFutureDateYear() {
        $thisYear = intval(date('Y'));
        $this->_testIsFuture($thisYear, false);

        $nextYear = intval(date('Y')) + 1;
        $this->_testIsFuture($nextYear, true);
    }

    private function _testIsFuture($date, $isFuture) {
        $element = $this->_createElement(array());
        $this->assertEquals($element->isFutureDate($date), $isFuture);
    }

    private function _mockEpisode($params) {
        return new BBC_Service_Bamboo_Models_Episode((object) $params);
    }

    private function _createElement($params) {
        return new BBC_Service_Bamboo_Models_Element((object) $params);
    }
}
