<?php

namespace models\commands;

use models\mapper\ArrayOf;

class FlashTemplateData
{
	public $name;
	
	public $fieldId;
	
	public $value;
	
	public $useDefaultOnly;
	
}

class FlashTemplateInputCommandModel extends InputResourceCommandModel
{
	
	public function __construct() {
		$this->dataSet = new ArrayOf(ArrayOf::OBJECT, function($data) {
			return new FlashTemplateData();
		});
	}
	
	public function casparCommandIn($userData) {
		$templateData = '<templateData>';
		foreach ($this->dataSet->data as $dataItem) {
			$value = $dataItem->value;
			if (!empty($userData)) {
				if (key_exists($dataItem->fieldId, $userData)) {
					$value = $userData[$dataItem->fieldId]->value;
				}
			}
			$componentData = sprintf('<componentData id=\"%s\">', $dataItem->fieldId);
			$componentData .= sprintf('<data id=\"text\" value=\"%s\"/>', $value);
			$componentData .= '</componentData>';
			$templateData .= $componentData;
		}
		$templateData .= '</templateData>';
		
		// Note:  FlashLayer and the other '1' not yet supported.
		$result = sprintf(
			'CG %d-%d ADD 1 "%s" 1 "%s"', 
			$this->channel, $this->layer, $this->resourceName, $templateData
		);
		return $result;
	}
	
	public function casparCommandOut() {
		// Note Flash layer not yet supported
		$result = sprintf('STOP %d-%d 1', $this->channel, $this->layer);
		return $result;
	}
	
	public $dataSet;
	
}

?>
