<?php
class BBC_Service_Bamboo_Models_BaseTest extends PHPUnit_Framework_TestCase
{

    const SECONDS_IN_A_YEAR = 31536000;
    const SECONDS_IN_A_WEEK = 604800;
    const SECONDS_IN_A_DAY = 86400;

    /*
    * We use a mocked Base object here
    */
    public function testGetId() {
        $params = array('id'=>'p01b2b5c');
        $base = $this->_createBase($params);

        $this->assertEquals($base->getId(), 'p01b2b5c');
    }

    public function testGetResponse() {
        $params = array('response'=> (object) array());
        $base = $this->_createBase($params);

        $this->assertEquals(get_class($base->getResponse()), 'stdClass');
    }

    /*
     * SetVersions and NOT getVersions as checking Base SetVersions() runs as expected.
     * Using a mocked Episode object.
     */
    public function testSetVersions() {
        $params = array('versions' => array(0 => array('id' => 'b036y9g5')));
        $mockedEpisode = $this->_mockEpisode($params);
        $versions = $mockedEpisode->getVersions();
        $firstVersion = $versions[0];

        $this->assertEquals(get_class($firstVersion), 'BBC_Service_Bamboo_Models_Version');
    }

    public function testSetPropertySubtitle() {
        $params = array('subtitle' => 'Series 3 - Episode 1');
        $mockedEpisode = $this->_mockEpisode($params);

        $this->assertEquals($mockedEpisode->getSubtitle(), 'Series 3 - Episode 1');
    }

    public function testSetPropertyTleoId() {
        $params = array('tleo_id' => 'b00vk2lp');
        $mockedEpisode = $this->_mockEpisode($params);

        $this->assertEquals($mockedEpisode->getTleoId(), 'b00vk2lp');
    }

    public function testSetVersionsSetPropertyId() {
        $params = array('versions' => array(0 => (object) array('id' => 'b036y9g5')));
        $mockedEpisode = $this->_mockEpisode($params);
        $versions = $mockedEpisode->getVersions();
        $firstVersion = $versions[0];

        $this->assertEquals($firstVersion->getId(), 'b036y9g5');
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

    /* Testing dates like junk */
    public function testIsFutureJunk() {
        $this->_testIsFuture("This is junk", false);
        $this->_testIsFuture("", false);
    }

    private function _testIsFuture($date, $isFuture) {
        $element = $this->_createBase(array());
        $this->assertEquals($element->isFutureDate($date), $isFuture);
    }


    private function _mockEpisode($params) {
        return new BBC_Service_Bamboo_Models_Episode((object) $params);
    }

    private function _createBase($params) {
        return new BBC_Service_Bamboo_Models_Base((object) $params);
    }

}
