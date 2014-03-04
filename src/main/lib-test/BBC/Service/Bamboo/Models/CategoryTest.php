<?php

class BBC_Service_Bamboo_Models_CategoryTest extends PHPUnit_Framework_TestCase
{
    public function testCBBCIsChildrens() {
        $category = $this->_createCategory(array('id' => 'cbbc'));
        $this->assertTrue($category->isChildrens());
    }

    public function testCbeebiesIsChildrens() {
        $category = $this->_createCategory(array('id' => 'cbeebies'));
        $this->assertTrue($category->isChildrens());
    }

    public function testComedyIsNotChildrens() {
        $category = $this->_createCategory(array('id' => 'comedy'));
        $this->assertFalse($category->isChildrens());
    }

    public function testChildEpisodeCount() {
        $category = $this->_createCategory(array('child_episode_count' => 28));
        $this->assertEquals($category->getChildEpisodeCount(), 28);

        // Test it returns 0 by default
        $category = $this->_createCategory(array());
        $this->assertEquals($category->getChildEpisodeCount(), 0);
    }

    private function _createCategory($params) {
        return new BBC_Service_Bamboo_Models_Category((object) $params);
    }
}
