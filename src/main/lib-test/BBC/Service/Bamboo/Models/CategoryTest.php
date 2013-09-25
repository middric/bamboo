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

    private function _createCategory($params) {
        return new BBC_Service_Bamboo_Models_Category((object) $params);
    }
}
