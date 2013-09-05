<?php
namespace models;

use models\mapper\ArrayOf;
use models\mapper\Id;
use models\mapper\JsonDecoder;

class ResourceModel extends mapper\MapperModel
{
	const TYPE_VIDEO = 1;
	const TYPE_IMAGE = 2;
	const TYPE_FLASH = 3;
	
	public function __construct($id = '') {
		$this->id = new Id();
		parent::__construct(ResourceMongoMapper::instance(), $id);
	}
	
	/**
	 * @var Id
	 */
	public $id;

	/**
	 * @var string
	 */
	public $resourceName;
	
	/**
	 * @var int
	 */
	public $type;
	
	/**
	 * @var string
	 */
	public $thumbUrl;
	
}

?>