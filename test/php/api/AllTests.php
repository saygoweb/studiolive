<?php
require_once(dirname(__FILE__) . '/../TestConfig.php');
require_once(SIMPLE_TEST_PATH . 'autorun.php');

class AllApiTests extends TestSuite {
	
    function __construct() {
        parent::__construct();
 		$this->addFile(TEST_PATH . 'api/ShowAPI_Test.php');
 		$this->addFile(TEST_PATH . 'api/SceneAPI_Test.php');
    }

}

?>