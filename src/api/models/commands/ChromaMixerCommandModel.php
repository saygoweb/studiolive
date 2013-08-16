<?php

namespace models\commands;

class ChromaMixerCommandModel extends InputCommandModel
{
	public function casparCommandIn() {
		$result = sprintf(
				'MIXER %d-%d CHROMA %s %.3f %.3f',
				$this->channel, $this->layer,
				$this->chroma, $this->low, $this->high
		);
		return $result;
	}
	
	public function casparCommandOut() {
		$result = sprintf('MIXER %d-%d CHROMA none', $this->channel, $this->layer);
		return $result;
	}
	
	/**
	 * The chroma color. Either Blue or Green
	 * @var string
	 */
	public $chroma;
	
	/**
	 * Chroma low threashold. 0.18
	 * @var double
	 */
	public $low;
	
	/**
	 * Chroma high threshold. 0.22
	 * @var double 
	 */
	public $high;
	
}

?>
