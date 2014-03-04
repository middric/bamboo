<?php

class BBC_Service_Bamboo_Models_GroupTest extends PHPUnit_Framework_TestCase
{
    /**
     * This tests checks the generation of the group model
     *
     * @access public
     * @return void
     */

    public function testEditorialType() {
        $group = $this->_createGroup();
        $this->assertEquals('editorial', $group->getIstatsType());
    }

    public function testStackedType() {
        $group = $this->_createGroup(array('stacked' => true));
        $this->assertEquals('series-catchup', $group->getIstatsType());
    }

    public function testPopularType() {
        $group = $this->_createGroup(array('id' => 'popular'));
        $this->assertEquals('most-popular', $group->getIstatsType());
    }

    private function _createGroup($params = array()) {
        $group = array(
            "id" => "fake_id"
        );
        return new BBC_Service_Bamboo_Models_Group((object) array_merge($group, $params));
    }
}
