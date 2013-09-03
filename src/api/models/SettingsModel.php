<?php
namespace models;

use models\mapper\ArrayOf;
use models\mapper\Id;
use models\mapper\JsonDecoder;

class PreviewSetting
{
	public $channel;
	
	public $urlRx;
	
	public $urlTx;
	
	
}

class CameraSetting
{
	public $name;
	
	public $uri;
}

class SettingsModel extends mapper\MapperModel
{
	const DEFAULT_PROFILE = '100000000000000000000000';
	
	public function __construct($id = '') {
		$this->id = new Id();
		$this->cameras = new ArrayOf(ArrayOf::OBJECT, function($data) {
			return new CameraSetting();
		});
		$this->previews = new ArrayOf(ArrayOf::OBJECT, function($data) {
			return new PreviewSetting();
		});
		parent::__construct(ShowModelMongoMapper::instance(), $id);
	}
	
	/**
	 * Reads the id, or creates a new object if it does not exist.
	 * @param string $id
	 */
	public function readOrCreate($id) {
		if (!$this->exists($id)) {
			$this->resetDefault();
		} else {
			$this->read($id);
		}
	}
	
	/**
	 * Resets the settings back to their default values.
	 */
	public function resetDefault($id) {
		$data = array(
			'id' => $id,
			'cameras' => array(
					array('name' => 'Sony Camera', 'uri' => 'dshow://video=Sony Visual Communication Camera'),
					array('name' => 'Life Cam', 'uri' => 'dshow://video=Microsoft Life Cam Studio')
			),
			'previews' => array(
					array('channel' => 1, 'urlRx' => 'udp://@239.7.7.1:12345', 'urlTx' => 'udp://239.7.7.1:12345'),
					array('channel' => 2, 'urlRx' => 'udp://@239.7.7.1:12346', 'urlTx' => 'udp://239.7.7.1:12346')
			)
		);
		JsonDecoder::decode($this, $data);
		$this->write();
	}

	public $id;

	/**
	 * @var ArrayOf
	 */
	public $cameras;
	
	/**
	 * @var ArrayOf
	 */
	public $previews;
	
}

?>