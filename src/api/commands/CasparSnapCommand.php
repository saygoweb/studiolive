<?php
namespace commands;

use models\mapper\caspar\CasparConnection;

class CasparSnapCommand
{
	
	public function __construct() {
	}
	
	/**
	 * Returns a relative URL to the snapshot file.
	 * @param int $channel
	 * @return string
	 */
	public function snap($channel) {
		// Send the PRINT command to Caspar
		$this->sendSnapCommand($channel);
		sleep(1);
		// Find the file Caspar saved
		$snapfileName = $this->findSnapFileName();
		
		// Copy the file under the web root/images/snap folder, renaming it along the way.
		$casparSnapFilePath = self::casparFilePath($snapfileName);
		$studioLiveSnapFilePath = self::studioLiveFilePath($snapfileName);
		copy($casparSnapFilePath, $studioLiveSnapFilePath);

		// Delete the original from Caspar
		unlink($casparSnapFilePath);
		
		return self::relativeUrl($snapfileName);
		
	}
	
	public function sendSnapCommand($channel) {
		$caspar = CasparConnection::connect(CASPAR_HOST, CASPAR_PORT);
		$response = $caspar->sendString("PRINT $channel\r\n");
		$response = trim($response[0]);
		if ($response != '202 PRINT OK') {
			throw new \Exception("Caspar error: $response");
		}
	}
	
	public function findSnapFileName() {
		$it = new \DirectoryIterator(CASPAR_PATH_SNAP);
		$fileNames = array();
		foreach ($it as $fileinfo) {
			if ($fileinfo->isFile()) {
				$fileNames[$fileinfo->getCTime()] = $fileinfo->getFilename();
			}
		}
		if (count($fileNames) == 0) {
			throw new \Exception(sprintf("Snap file not found in '%s'", CASPAR_PATH_SNAP));
		}
		krsort($fileNames, SORT_NUMERIC);
		foreach ($fileNames as $fileName) {
			return $fileName;
		}
	}
	
	private static function casparFilePath($fileName) {
		return sprintf('%s%s%s', CASPAR_PATH_SNAP, DIRECTORY_SEPARATOR, $fileName);
	}
	
	private static function studioLiveFilePath($fileName) {
		return sprintf('%s%s%s', SL_PATH_SNAP, DIRECTORY_SEPARATOR, $fileName);
	}
	
	private static function relativeUrl($fileName) {
		return sprintf('/images/snap/%s', $fileName);
	}
}

?>
