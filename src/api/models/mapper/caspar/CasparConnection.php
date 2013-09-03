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
	 */
	public function sendString($casparCommand) {
		$casparCommand .= "\r\n";
		$socket = $this->getConnectedSocket();
		socket_set_option($socket,SOL_SOCKET, SO_RCVTIMEO, array("sec"=>5, "usec"=>0));
		socket_write($socket, $casparCommand, strlen($casparCommand));
		while ($response = socket_read($socket, 1024, PHP_NORMAL_READ)) {
			// unlikely to get a long or fragmented response, so we igore that for now.
			break;
		}
		// TODO REVIEW Do we need to flush any remainder?
		return $response;		
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