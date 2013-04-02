<?php

class BBC_Service_BambooTest extends PHPUnit_Framework_TestCase {
	
	protected $_service;
	
    /**
     * Runs the test methods of this class.
     *
     * @access public
     * @static
     */
	public function main() {
		require_once 'PHPUnit/TextUI/TestRunner.php';

		$suite  = new PHPUnit_Framework_TestSuite('BBC_Service_BambooTest');
		$result = PHPUnit_TextUI_TestRunner::run($suite);
	}
	
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp() {

    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown() {
    }
    
    public function testBambooService() {
    }
}

