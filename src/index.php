<?php

require_once('Config.php');

/**
 * @param string $filePath
 * @param array $vars
 */
function renderView($filePath, $vars) {
	extract($vars); // Extract the vars to local namespace
//	ob_start();
	// Including the file will render it directly. Templates are mostly html
	include ($filePath);
//	$contents = ob_get_contents();
//	ob_end_clean();
//	return $contents;
}

function getScripts() {
	$it = new RecursiveDirectoryIterator('app-ng');
	$it = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::SELF_FIRST);
	
	$scripts = array();
	foreach ($it as $file) {
		if ($file->isFile()) {
			$ext = $file->getExtension();
			$isMin = (strpos($file->getPathname(), '-min') !== false);
			if (!$isMin && $ext == 'js') {
				$scripts[] = '/' . $file->getPathname();
			}
		}
	}
	return $scripts;
}

function main() {
	if (USE_BOOT && !isset($_GET['skipboot'])) {
		if (file_exists('boot.php')) {
			require_once('boot.php');
			Boot::ensureMongoLoaded();
		}
	}
	$vars = array();
	if (!USE_LIBS) {
		$vars['scripts'] = getScripts();
	} else {
		$vars['scripts'][] = '/app-ng/studiolive/studiolive-min.js';
	}
	$vars['version'] = VERSION . ' ' . BUILD_DATE;
	renderView('app-ng/studiolive/app-ng.html.php', $vars);
}

main();


?>