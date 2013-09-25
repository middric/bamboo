<?php

class BBC_Service_Bamboo_Models_CategoryTest extends PHPUnit_Framework_TestCase
{
    public function testCBBCRequiresParentalGuidance() {
        $category = $this->_createCategory(array('id' => 'cbbc'));
        $this->assertTrue($category->requiresParentalGuidance());
    }

    public function testCbeebiesRequiresParentalGuidance() {
        $category = $this->_createCategory(array('id' => 'cbeebies'));
        $this->assertTrue($category->requiresParentalGuidance());
    }

    public function testOnlyChildrensCategoriesRequireParentalGuidance() {
        $category = $this->_createCategory(array('id' => 'another_category'));
        $this->assertFalse($category->requiresParentalGuidance());
    }

    private function _createCategory($params) {
        return new BBC_Service_Bamboo_Models_Category((object) $params);
    }
}
