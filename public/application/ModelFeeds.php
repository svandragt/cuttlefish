<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class ModelFeeds extends Model {
	public $model = array(
		'yaml' => 'metadata',
		'markdown|html' => 'content',
	);

	public function init() {
 		$this->load_contents();
	}

}