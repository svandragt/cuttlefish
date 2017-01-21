<?php 

namespace VanDragt\Carbon\App;

use VanDragt\Carbon\Sys;

if (!defined('BASE_FILEPATH'))
{
	exit('No direct script access allowed');
}

class ModelFile extends Sys\Model
{

	// File model

	public $model = array();

	function contents($records, $Environment)
	{
		$this->contents = $records;
	}

}