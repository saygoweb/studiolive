<?php

namespace models\commands;

class CommandModel
{
	public function __construct() {
	}

	/**
	 * Removes the record $id from the collection.
	 * @param string $id
	 * @return int The number of records removed from the collection.
	 */
	public static function remove($id) {
		return ShowModelMongoMapper::instance()->remove($id);
	}
	
	public static function createCommand($type) {
		switch ($type) {
			case 'Camera':
				return new USBCameraInputCommandModel();
			case 'Flash Template':
				return new FlashTemplateInputCommandModel();
			case 'Image':
				return new ImageInputCommandModel();
			case 'Stream':
				return new StreamInputCommandModel();
			case 'Video':
				return new VideoFileInputCommandModel();
			case 'Geometry':
				return new GeometryMixerCommandModel();
			case 'Opacity':
				return new OpacityMixerCommandModel();
			case 'Chroma':
				return new ChromaMixerCommandModel();
			case 'File':
				return new VideoFileOutputCommandModel();
			default:
				throw new \Exception("Unsupported type '$type'");
		}
	}

	public $type;
	
	public $name;
	
}

?>
