<?php

namespace models\mapper\caspar;

use libraries\palaso\CodeGuard;

class CasparConnection
{
	
	static $_instance = null;
	
	/**
	 * @param string $host
	 * @param string $port
	 * @return CasparConnection
	 */
	public static function connect($host, $port) {
		if (self::$_instance == null) {
			self::$_instance = new CasparConnection($host, $port);
		}
		return self::$_instance;
	}
	
	/**
	 * @return CasparConnection
	 */
	public static function instance() {
		CodeGuard::checkNullAndThrow(self::$_instance, '$_instance');
		return self::$_instance;
	}
	
	private $_host;
	private $_port;
	private $_socket = null;
	private $_address = null;
	
	private function __construct($host, $port) {
		$this->_host = $host;
		$this->_port = $port;
	}
	
	public function close() {
		socket_close($this->_socket);
	}
	
	/**
	 * @param string $casparCommand
	 * @return array<string> Reponse from server.
	 */
	public function sendString($casparCommand) {
		$casparCommand .= "\r\n";
		$socket = $this->getConnectedSocket();
		socket_set_option($socket,SOL_SOCKET, SO_RCVTIMEO, array("sec"=>1, "usec"=>0));
		socket_write($socket, $casparCommand, strlen($casparCommand));
		$result = array();
		$line = '';
		$col = 0;
		$stop = false;
		while (!$stop) {
			$c = socket_read($socket, 1);
			if ($c === false) {
				$stop = true;
				continue;
			}
			switch ($c) {
				case "\r":
// 					var_dump("skip");
					break;
				case "\n":
					if ($col == 0) {
// 						var_dump("end");
						$stop = true;
					} else {
// 						var_dump("eol");
// 						var_dump($line);
						$result[] = $line;
						$col = 0;
						$line = '';
					}
					break;
				default:
					$line .= $c;
					$col++;
			}
		}
		return $result;		
	}
	
	private function getConnectedSocket() {
		if ($this->_socket !== null) {
			return $this->_socket;
		}
		if ($this->_address === null) {
			$address = gethostbyname($this->_host);
			if ($address == $this->_host) {
				// Failed
				throw new \Exception("Could not resolve '$this->_host'");
			}
			$this->_address = $address;
		}
		$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		if ($socket === false) {
			throw new \Exception("socket_create() failed: reason: " . socket_strerror(socket_last_error()));
		}
		$result = socket_connect($socket, $this->_address, $this->_port);
		if ($result === false) {
			throw new \Exception("socket_connect() failed: reason: " . socket_strerror(socket_last_error($socket)));
		}
		$this->_socket = $socket;
		return $this->_socket;
	}
	
	
}

?>