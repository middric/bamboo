<?php

class BBC_Service_Bamboo_Models_PromotionTest extends PHPUnit_Framework_TestCase
{
    /**
     * This tests checks the generation of the Promotion model
     * 
     * @access public
     * @return void
     */
    public function testValues() {
        $promotion = $this->_createPromotion();
        $this->assertEquals("Donate", $promotion->getPromotionLabel());
        $this->assertEquals('Child in Need', $promotion->getTitle());
        $this->assertEquals(
            "Donate to help to change children's lives",
            $promotion->getSubtitle()
        );
        $this->assertEquals(
            "Donate online, via PayPal or find out about other ways to give us your money.",
            $promotion->getDescription()
        );
        $this->assertEquals(
            'http://www.bbc.co.uk/programmes/b008dk4b/features/cin-donate',
            $promotion->getUrl()
        );
        $this->assertEquals(
            'http://ichef.bbci.co.uk/images/ic/{recipe}/legacy/images/p01hjz4s.jpg',
            $promotion->getStandardImageRecipe('standard')
        );
    }

    public function testEmptyData() {
        $promotion = $this->_createPromotion(array('title'=>'', 'subtitle'=>'','synopses'=>array()));
        $this->assertEquals('', $promotion->getTitle());
        $this->assertEquals('', $promotion->getSubtitle());
        $this->assertEquals('', $promotion->getDescription());
    }


    private function _createPromotion($params = array()) {
        $promotion = array(
            "id" => "b036tchs",
            "type" => "promotion",
            "title" => "Child in Need",
            "subtitle" => "Donate to help to change children's lives",
            "synopses" => array(
                "small" => "Donate online, via PayPal or find out about other ways to give us your money."
            ),
            "url" => "http://www.bbc.co.uk/programmes/b008dk4b/features/cin-donate",
            "images" => array(
                "standard" => "http://ichef.bbci.co.uk/images/ic/{recipe}/legacy/images/p01hjz4s.jpg"
            ),
            "labels" => array(
                "promotion" => "Donate"
            )
        );
        return new BBC_Service_Bamboo_Models_Promotion((object) array_merge($promotion, $params));
    }
}
