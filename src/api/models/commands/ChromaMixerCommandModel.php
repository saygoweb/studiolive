<?php

namespace models\commands;

class ChromaMixerCommandModel extends InputCommandModel
{

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
