<?php
require_once(dirname(__FILE__) . '/../TestConfig.php');
require_once(SIMPLE_TEST_PATH . 'autorun.php');

class AllCommandsTests extends TestSuite {
	
    function __construct() {
        parent::__construct();
 		$this->addFile(TEST_PATH . 'commands/CasparSnapCommand_Test.php');
 		$this->addFile(TEST_PATH . 'commands/ShowCommands_Test.php');
    }

}

?>