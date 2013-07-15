<?php
require_once(dirname(__FILE__) . '/TestConfig.php');
require_once(SIMPLE_TEST_PATH . 'autorun.php');

class AllTests extends TestSuite {
	
    function __construct() {
        parent::__construct();
 		$this->addFile(TEST_PATH . 'model/AllTests.php');
 		$this->addFile(TEST_PATH . 'commands/AllTests.php');
		$this->addFile(TEST_PATH . 'api/AllTests.php');
    }
}
?>