#!/usr/bin/php
<?php
/**
 * @author Cambell Prince
 */

// Include the Console_CommandLine package.
require_once 'Console/CommandLine.php';

define('QUIET_MODE', '0');

// create the parser
$parser = new Console_CommandLine(array(
		'description' => 'Build a phar archive and sign it using a private key from a given file',
		'version'     => '@VERSION@',
		'name'        => 'makephar',
));

$parser->addOption('src', array(
		'short_name'  => '-s',
		'long_name'   => '--src',
		'action'      => 'StoreString',
		'default'     => '../src',
		'description' => "Source files directory\n(./src)"
));

$parser->addOption('stub', array(
		'short_name'  => '-S',
		'long_name'   => '--stub',
		'action'      => 'StoreString',
		'default'     => './stub.php',
		'description' => "(optional) stub file for phar \n(./stub.php)\nIf stub file does not exist, default stub will be used."
));
$parser->addOption('exclude_files', array(
		'short_name'  => '-x',
		'long_name'   => '--exclude',
		'action'      => 'StoreString',
		'default'     => '~$ .js .gif .png .jpg',
		'description' => "Space separated regular expressions of filenames that should be excluded\n(\"~$\" by default)"
));

$parser->addOption('quiet', array(
		'short_name'   => '-q',
		'long_name'   => '--quiet',
		'action'      => 'StoreTrue',
		'description' => 'Suppress most of the output statements.'
));

$parser->addOption('phar', array(
		'long_name'   => '--phar',
		'action'      => 'StoreString',
		'default'     => './output.phar',
		'description' => "Output Phar archive filename\n(./output.phar)",
));

// run the parser
try {
	$result = $parser->parse();
} catch (Exception $exc) {
	$parser->displayError($exc->getMessage());
}

$options = $result->options;

$phar = new Phar($options['phar']);

$it = new RecursiveDirectoryIterator($options['src']);
$it = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::SELF_FIRST);
$it = new ExcludeFilesIterator($it, $options['exclude_files']);

$phar->startBuffering();
foreach ($it as $file) {
	if ($file->isFile()) {
		$filePath = $file->getPathname();
		$local = stripFolderPrefix($options['src'], $filePath);
		echo 'adding ' . $filePath . ' as ' . $local . "\n";
		$phar->addFromString($local, php_strip_whitespace($filePath));
//  		$phar->addFile($filePath, $local);
	}
}
$phar->stopBuffering();

function stripFolderPrefix($needle, $haystack) {
	if (strpos($haystack, $needle) !== 0) // not in the beginning/not found
		return $haystack;

	return substr($haystack, strlen($needle));
}

class ExcludeFilesIterator extends FilterIterator {

	protected $_excludes;

	public function __construct(Iterator $i, $exclude_file) {
		parent::__construct($i);
		$this->_excludes = array_map(
			function($pattern) { return '|' . $pattern . '|'; },
			preg_split("/ +/", $exclude_file, -1, PREG_SPLIT_NO_EMPTY)
		);
	}

    public function accept() {
        $file = $this->current();
        foreach ($this->_excludes as $pattern) {
            if (preg_match($pattern, $file->getPathname())) {
                if(!QUIET_MODE) {
                    echo "skipping $file\n";
                }
                return false;
            }
        }
        return true;
    }
}
	
?>
